<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\User;

use App\Service\LivretPdfService;
use App\Service\StatService;


class ArchivageController extends Controller
{
    public function index() 
    {
        return view('archivage.index');
    }
    public function restaurer($id) 
    {
        $user=User::withTrashed()->find($id);
        $user->deleted_at = null;
        $user->save();

        return redirect()->route('archivage.index')
            ->withSuccess(__('Utilisateur restauré avec succès.'));
    }
    public function imprimer($id) 
    {
        // telechargement du livret pdf
        $user=User::withTrashed()->find($id);
        LivretPdfService::livretpdf($user, '');
    }
    public function archiver($id) 
    {
        $user=User::withTrashed()->find($id);
        // suppression du user = on le cache mais on le supprime pas vraiment 
        // en assignant deleted_at si pas fait et date_archivage.
        $user->date_archivage=Carbon::now();
        if (!$user->deleted_at) {$user->deleted_at=Carbon::now();}
        $user->save();
        // inscription dans table statistiques
        StatService::statuser($user);
        // impression du livret pdf
        LivretPdfService::livretpdf($user, 'archiv');

        return redirect()->route('archivage.index')
            ->withSuccess(__('Utilisateur archivé avec succès.'));
    }
}