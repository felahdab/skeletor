<?php
namespace  App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;


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
