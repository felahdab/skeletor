<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class PermissionPolicy extends GenericSkeletorPolicy
{
   protected $slug='permissions';

   /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?Authenticatable $user): bool
    {
        if ($user == null)
            return false;
        return $user->admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Authenticatable $user, Model $model): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Model $model): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Model $model): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

    /**
     * Determine whether the user can delete any model.
     */
    public function deleteAny(Authenticatable $user): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Authenticatable $user, Model $model): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Authenticatable $user, Model $model): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete any model.
     */
    public function forceDeleteAny(Authenticatable $user): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

    /**
     * Determine whether the user can reorder the model.
     */
    public function reorder(Authenticatable $user): bool
    {        
      if ($user == null)
         return false;
      return $user->admin;
    }

}
