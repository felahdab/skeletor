<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\Response;

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
    public function viewAny(User $user): bool
    {
        return $user->can($this->slug . '.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Model $model): bool
    {
        return $user->can($this->slug . '.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.create',
            $this->slug . '.store'
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.update'
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.delete'
        ]);
    }

    /**
     * Determine whether the user can delete any model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.deleteAny'
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.restore'
        ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Model $model): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.forceDelete'
        ]);
    }

    /**
     * Determine whether the user can permanently delete any model.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.forceDeleteAny'
        ]);
    }

    /**
     * Determine whether the user can reorder the model.
     */
    public function reorder(User $user): bool
    {
        return $user->hasAnyPermission([
            $this->slug . '.reorder'
        ]);
    }
}
