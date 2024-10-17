<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Remotesystem;

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
    public function viewAny(User|Remotesystem $user): bool
    {
        return $user->can($this->slug . '.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|Remotesystem $user, Model $model): bool
    {
        return $user->can($this->slug . '.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|Remotesystem $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.create',
            $this->slug . '.store'
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|Remotesystem $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.update'
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|Remotesystem $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.delete'
        ]);
    }

    /**
     * Determine whether the user can delete any model.
     */
    public function deleteAny(User|Remotesystem $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.deleteAny'
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User|Remotesystem $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.restore'
        ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User|Remotesystem $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.forceDelete'
        ]);
    }

    /**
     * Determine whether the user can permanently delete any model.
     */
    public function forceDeleteAny(User|Remotesystem $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.forceDeleteAny'
        ]);
    }

    /**
     * Determine whether the user can reorder the model.
     */
    public function reorder(User|Remotesystem $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.reorder'
        ]);
    }
}
