<?php
namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;
/**
 * Class Version
 * @package Mpociot\Versionable
 */
class Version extends Eloquent
{

    /**
     * @var string
     */
    public $table = "versions";

    /**
     * @var string
     */
    protected $primaryKey = "version_id";

    /**
     * Sets up the relation
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function versionable()
    {
        return $this->morphTo();
    }

    /**
     * Return the user responsible for this version
     * @return mixed
     */
    public function getResponsibleUserAttribute()
    {
        $model = Config::get("auth.providers.users.model");
        return $model::find($this->user_id);
    }

    /**
     * Return the versioned model
     * @return Model
     */
    public function getModel()
    {
        $modelData = is_resource($this->model_data)
            ? stream_get_contents($this->model_data,-1,0)
            : $this->model_data;

        $className = self::getActualClassNameForMorph($this->versionable_type);
        $model = new $className();
        $model->unguard();
        $model->fill(unserialize($modelData));
        $model->exists = true;
        $model->reguard();
        return $model;
    }


    /**
     * Revert to the stored model version make it the current version
     *
     * @return Model
     */
    public function revert()
    {
        $model = $this->getModel();
        unset( $model->{$model->getCreatedAtColumn()} );
        unset( $model->{$model->getUpdatedAtColumn()} );
        if (method_exists($model, 'getDeletedAtColumn')) {
            unset( $model->{$model->getDeletedAtColumn()} );
        }
        $model->save();
        return $model;
    }

    /**
     * Diff the attributes of this version model against another version.
     * If no version is provided, it will be diffed against the current version.
     *
     * @param Version|null $againstVersion
     * @return array
     */
    public function diff(Version $againstVersion = null)
    {
        $model = $this->getModel();
        $diff  = $againstVersion ? $againstVersion->getModel() : $this->versionable()->withTrashed()->first()->currentVersion()->getModel();

        $diffArray = array_diff_assoc($diff->getAttributes(), $model->getAttributes());

        if (isset( $diffArray[ $model->getCreatedAtColumn() ] )) {
            unset( $diffArray[ $model->getCreatedAtColumn() ] );
        }
        if (isset( $diffArray[ $model->getUpdatedAtColumn() ] )) {
            unset( $diffArray[ $model->getUpdatedAtColumn() ] );
        }
        if (method_exists($model, 'getDeletedAtColumn') && isset( $diffArray[ $model->getDeletedAtColumn() ] )) {
            unset( $diffArray[ $model->getDeletedAtColumn() ] );
        }

        return $diffArray;
    }

    /**
     * Diff the attributes of this version model against another version.
     * If no version is provided, it will be diffed against the current version.
     *
     * @param Version|null $againstVersion
     * @return array
     */
    public function diffRaw(Version $againstVersion = null)
    {
        $model = $this->getModel();

        $this_data = Arr::dot(unserialize($this->model_data));

        $diff  = $againstVersion ? $againstVersion->model_data : $this->versionable()->withTrashed()->first()->currentVersion()->model_data;
        $against_data = Arr::dot(unserialize($diff));

        // Ca marche mais c'est pas terrible...
        foreach ($this_data as $key=>$value)
        {
            if ($value == [])
            {
                $this_data[$key] = null;
            }
        }
        foreach ($against_data as $key=>$value)
        {
            if ($value == [])
            {
                $against_data[$key] = null;
            }
        }

        $changed_keys = array_diff_assoc($this_data, $against_data);
        

        if (isset( $changed_keys[ $model->getCreatedAtColumn() ] )) {
            unset( $changed_keys[ $model->getCreatedAtColumn() ] );
        }
        if (isset( $changed_keys[ $model->getUpdatedAtColumn() ] )) {
            unset( $changed_keys[ $model->getUpdatedAtColumn() ] );
        }
        if (method_exists($model, 'getDeletedAtColumn') && isset( $changed_keys[ $model->getDeletedAtColumn() ] )) {
            unset( $changed_keys[ $model->getDeletedAtColumn() ] );
        }

        $diffArray = [];

        foreach($changed_keys as $key=>$value)
        {
            $valeur_actuel = Arr::get($this_data, $key);
            $valeur_autre = Arr::get($against_data, $key);
            Arr::set($diffArray, "avant." . $key, $valeur_autre);
            Arr::set($diffArray, "apres." . $key, $valeur_actuel);
            
        }
        Arr::set($diffArray, "user", $this->user_id);
        Arr::set($diffArray, "timestamp", $this->created_at);
        Arr::set($diffArray, "reason", $this->reason);

        return Arr::undot($diffArray);

    }

}
