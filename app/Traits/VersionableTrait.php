<?php

namespace App\Traits;

use App\Models\Version;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

/**
 * Class VersionableTrait.
 */
trait VersionableTrait
{
    /**
     * Flag that determines if the model allows versioning at all.
     *
     * @var bool
     */
    protected $versioningEnabled = true;

    /**
     * Private variable to detect if this is an update
     * or an insert.
     *
     * @var bool
     */
    private $updating;

    /**
     * Contains all dirty data that is valid for versioning.
     *
     * @var array
     */
    private $versionableDirtyData;

    /**
     * Optional reason, why this version was created.
     *
     * @var string
     */
    private $reason;

    /**
     * @return $this
     */
    public function enableVersioning()
    {
        $this->versioningEnabled = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function disableVersioning()
    {
        $this->versioningEnabled = false;

        return $this;
    }

    /**
     * Attribute mutator for "reason".
     * Prevent "reason" to become a database attribute of model.
     *
     * @param string $value
     */
    public function setReasonAttribute($value)
    {
        $this->reason = $value;
    }

    /**
     * Initialize model events.
     */
    public static function bootVersionableTrait()
    {
        static::saving(function ($model) {
            $model->versionablePreSave();
        });

        static::saved(function ($model) {
            $model->versionablePostSave();
        });
    }

    /**
     * Return all versions of the model.
     *
     * @return MorphMany
     */
    public function versions()
    {
        return $this->morphMany($this->getVersionClass(), 'versionable');
    }

    /**
     * Returns the latest version available.
     *
     * @return Version
     */
    public function currentVersion()
    {
        return $this->getLatestVersions()->first();
    }

    /**
     * Returns the previous version.
     *
     * @return Version
     */
    public function previousVersion()
    {
        return $this->getLatestVersions()->limit(1)->offset(1)->first();
    }

    /**
     * Get a model based on the version id.
     *
     * @return null|$this
     */
    public function getVersionModel($version_id)
    {
        $version = $this->versions()->where('version_id', '=', $version_id)->first();
        if (!is_null($version)) {
            return $version->getModel();
        }

        return null;
    }

    /**
     * Initialize a version on every instance of a model.
     */
    public static function initializeVersions()
    {
        foreach (self::all() as $obj) {
            $obj->createInitialVersion();
        }
    }

    /**
     * Save a new version.
     */
    public function createInitialVersion()
    {
        if (true === $this->fresh()->versions->isEmpty()
            && true === $this->versioningEnabled
        ) {
            $class = $this->getVersionClass();
            $version = new $class();
            $version->versionable_id = $this->getKey();
            $version->versionable_type = method_exists($this, 'getMorphClass') ? $this->getMorphClass() : get_class($this);
            $version->user_id = $this->getAuthUserId();

            $versionedHiddenFields = $this->versionedHiddenFields ?? [];
            $this->makeVisible($versionedHiddenFields);
            $version->model_data = serialize($this->attributesToArray());
            $this->makeHidden($versionedHiddenFields);

            if (!empty($this->reason)) {
                $version->reason = $this->reason;
            }

            $version->save();
        }
    }

    public function getSuccessiveChanges()
    {
        $ret = [];
        $versions = $this->versions()->orderBy('created_at', 'ASC')->get();

        $ret[] = [
            'avant' => [],
            'apres' => unserialize($versions[0]->model_data),
            'user' => $versions[0]->user_id,
            'timestamp' => $versions[0]->created_at,
            'reason' => $versions[0]->reason,
        ];

        $isFirst = true;
        $previous_version = $versions[0];
        foreach ($versions as $version) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $changes = $version->diffRaw($previous_version);
                $ret[] = $changes;
            }
            $previous_version = $version;
        }

        return $ret;
    }

    /**
     * Retrieve, if exists, the property that define that Version model.
     * If no property defined, use the default Version model.
     *
     * Trait cannot share properties whth their class !
     * http://php.net/manual/en/language.oop5.traits.php
     *
     * @return string|unknown
     */
    protected function getVersionClass()
    {
        if (property_exists(self::class, 'versionClass')) {
            return $this->versionClass;
        }

        return config('versionable.version_model', Version::class);
    }

    /**
     * Pre save hook to determine if versioning is enabled and if we're updating
     * the model.
     */
    protected function versionablePreSave()
    {
        if (true === $this->versioningEnabled) {
            $this->versionableDirtyData = $this->getDirty();
            $this->updating = $this->exists;
        }
    }

    /**
     * Save a new version.
     */
    protected function versionablePostSave()
    {
        // We'll save new versions on updating and first creation.
        if (
            (true === $this->versioningEnabled && $this->updating && $this->isValidForVersioning())
            || (true === $this->versioningEnabled && !$this->updating && !is_null($this->versionableDirtyData) && count($this->versionableDirtyData))
        ) {
            // Save a new version
            $class = $this->getVersionClass();
            $version = new $class();
            $version->versionable_id = $this->getKey();
            $version->versionable_type = method_exists($this, 'getMorphClass') ? $this->getMorphClass() : get_class($this);
            $version->user_id = $this->getAuthUserId();

            $versionedHiddenFields = $this->versionedHiddenFields ?? [];
            $this->makeVisible($versionedHiddenFields);
            $version->model_data = serialize($this->attributesToArray());
            $this->makeHidden($versionedHiddenFields);

            if (!empty($this->reason)) {
                $version->reason = $this->reason;
            }

            $version->save();

            $this->purgeOldVersions();
        }
    }

    /**
     * @return null|int
     */
    protected function getAuthUserId()
    {
        return Auth::check() ? Auth::id() : null;
    }

    /**
     * @return Builder
     */
    protected function getLatestVersions()
    {
        return $this->versions()->orderByDesc('version_id');
    }

    /**
     * Delete old versions of this model when they reach a specific count.
     */
    private function purgeOldVersions()
    {
        $keep = $this->keepOldVersions ?? 0;

        if ((int) $keep > 0) {
            $count = $this->versions()->count();

            if ($count > $keep) {
                $this->getLatestVersions()
                    ->take($count)
                    ->skip($keep)
                    ->get()
                    ->each(function ($version) {
                        $version->delete();
                    })
                ;
            }
        }
    }

    /**
     * Determine if a new version should be created for this model.
     * Checks if appropriate fields have been changed.
     *
     * @return bool
     */
    private function isValidForVersioning()
    {
        $removeableKeys = $this->dontVersionFields ?? [];
        if (($updatedAt = $this->getUpdatedAtColumn()) !== null) {
            $removeableKeys[] = $updatedAt;
        }

        if (method_exists($this, 'getDeletedAtColumn') && ($deletedAt = $this->getDeletedAtColumn()) !== null) {
            $removeableKeys[] = $deletedAt;
        }

        return  count(array_diff_key($this->versionableDirtyData, array_flip($removeableKeys))) > 0;
    }
}
