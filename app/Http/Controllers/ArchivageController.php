<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\User;

use App\Service\LivretPdfService;
use App\Service\StatService;
use App\Service\ArchivRestaurService;


class ArchivageController extends Controller
{
    public function index() 
    {
        return view('archivage.index');
    }

    public function conservcpte($user) 
    {
        $user = User::withTrashed()->find($user);
        ArchivRestaurService::restauravecdonnees($user,'archivage');
        return redirect()->route('archivage.index')
            ->withSuccess(__('Utilisateur restauré avec succès.'));
    }

    public function effacecpte($id) 
    {
        $user = User::withTrashed()->find($user);
        ArchivRestaurService::restaursansdonnees($user,'archivage');
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
        // Si l'utilisateur a un livret de tranfo: on génère le PDF et on l'enregistre sur le serveur.
        if ($user->fonctions->count()){
            LivretPdfService::livretpdf($user, 'archiv');
        }
        // On met a jour les statistiques avec ce marin.
        StatService::statuser($user);
        // On met a jour la date d'archivage.
        $user->date_archivage=Carbon::now();
        $user->save();

        return redirect()->route('archivage.index')
            ->withSuccess(__('Utilisateur archivé avec succès.'));
    }
    
    public function supprimer($id) 
    {
        $user=User::withTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('archivage.index')
            ->withSuccess(__('Utilisateur supprimé avec succès.'));
    }
}