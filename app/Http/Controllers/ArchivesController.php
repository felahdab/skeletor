<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Events\RestoreUserEvent;
use App\Events\DeleteUserEvent;

class ArchivesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('archives.index');
    }

    public function restore($user)
    {
        $user = User::withTrashed()->find($user);
        RestoreUserEvent::dispatch($user->id, 'archive');
        return redirect()->route('archives.index')
            ->withSuccess(__('Utilisateur restauré avec succès.'));
    }
    public function destroy($user)
    {
        $user=User::withTrashed()->find($user);
        DeleteUserEvent::dispatch($user->id, 'archive');
        return redirect()->route('archives.index')
            ->withSuccess(__('Utilisateur supprimé avec succès.'));
    }
}
