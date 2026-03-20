<?php

namespace App\Service;

use App\Models\User;

class ArchivesService
{
    public static function restaurer($id)
    {
        $user = User::withTrashed()->find($id)->first();
        $user->deleted_at = null;
        $user->save();
    }

    public static function supprimer($id)
    {
        $user = User::withTrashed()->find($id)->first();
        $user->forceDelete();
    }
}
