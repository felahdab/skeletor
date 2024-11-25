<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Remotesystem;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class GenericSkeletorPolicy
{
    protected $slug = '';

    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?Authenticatable $user): bool
    {
        if ($user == null)
            return false;
        return $user->can($this->slug . '.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Authenticatable $user, Model $model): bool
    {
        if ($user == null)
            return false;
        return $user->can($this->slug . '.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.create',
            $this->slug . '.store'
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.update'
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.delete'
        ]);
    }

    /**
     * Determine whether the user can delete any model.
     */
    public function deleteAny(Authenticatable $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.deleteAny'
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Authenticatable $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.restore'
        ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Authenticatable $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.forceDelete'
        ]);
    }

    /**
     * Determine whether the user can permanently delete any model.
     */
    public function forceDeleteAny(Authenticatable $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.forceDeleteAny'
        ]);
    }

    /**
     * Determine whether the user can reorder the model.
     */
    public function reorder(Authenticatable $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.reorder'
        ]);
    }
}
