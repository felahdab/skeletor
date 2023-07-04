<?php

namespace Modules\Transformation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\User;

use Modules\Transformation\Services\LivretPdfService;
use Modules\Transformation\Services\ArchivRestaurService;

use App\Http\Controllers\Controller;


class ArchivageController extends Controller
{
    public function index() 
    {
        return view('transformation::archivage.index');
    }

    public function conservcpte($user) 
    {
        $user = User::withTrashed()->find($user);
        ArchivRestaurService::restauravecdonnees($user,'archivage');
        return redirect()->route('transformation::archivage.index')
            ->withSuccess(__('Utilisateur restauré avec succès.'));
        }

    public function effacecpte($id) 
    {
        $user = User::withTrashed()->find($id);
        ArchivRestaurService::restaursansdonnees($user,'archivage');
        return redirect()->route('transformation::archivage.index')
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
        //archivage seulement si les données sont remplies
        if ($user->nid == null || $user->matricule == null || $user->grade_id == null || 
        $user->specialite_id == null || $user->diplome_id == null || $user->date_debarq == null || 
        $user->unite_destination_id == null  )
        {
            //dd($user->date_debarq);
            return redirect()->route('transformation::archivage.index')
            ->withError(__('Ce marin ne peut être archivé car ses données ne sont pas complètes (nid, matricule, date débarquement, grade, spécialité, brevet, unite de destination).'));
        }
        // Si l'utilisateur a un livret de tranfo: on génère le PDF et on l'enregistre sur le serveur.
        if ($user->fonctions->count()){
            LivretPdfService::livretpdf($user, 'archiv');
        }
        // On met a jour les statistiques avec ce marin.
        // StatService::statuser($user);
        ArchivRestaurService::archivageuser($user);
        // On met a jour la date d'archivage.
        $user->date_archivage=Carbon::now();
        $user->save();

        return redirect()->route('transformation::archivage.index')
            ->withSuccess(__('Utilisateur archivé avec succès.'));
    }
    
    public function supprimer($id) 
    {
        $user=User::withTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('transformation::archivage.index')
            ->withSuccess(__('Utilisateur supprimé avec succès.'));
    }
}