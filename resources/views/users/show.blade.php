@extends('layouts.app-master')

@section('helplink')
<x-help-link page="administration"/>
@endsection

@section('content')
    <div class="  p-4 rounded">
        <h2>Fiche du marin</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
    <div>
        <div class="container mt-4">
            <div class="row mt-4">
                <div class="col">
                    <x-form::input name="email" label="Email" type="email" :value="$user->email" disabled/>
                </div>
                <div class="col">
                    <x-form::input name="grade" label="Grade" type="text" :value="$user->grade->grade_libcourt" disabled/>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <x-form::input name="name" label="Nom" type="text" :value="$user->name" disabled/>
                </div>
                <div class="col">
                    <x-form::input name="specialite_id" label="Spécialité" type="text" :value="($user->specialite)  ? $user->specialite->specialite_libcourt : ' '" disabled/>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <x-form::input name="prenom" label="Prénom" type="text" :value="$user->prenom" disabled/>
                </div>
                <div class="col">
                    <x-form::input name="secteur_id" label="FPS rattach" type="text" :value="($user->secteur)  ? $user->secteur->secteur_libcourt : ' ' " disabled/>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col">
                    <x-form::input name="matricule" label="Matricule" type="text" :value="$user->matricule" disabled/>
                </div>
                <div class="col">
                    <x-form::input name="diplome_id" label="Orga FCM" type="text" :value="($user->diplome)  ? $user->diplome->diplome_libcourt : ' '" disabled/>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <x-form::input name="nid" label="NID" placeholder="NID..." type="text" :value="$user->nid" disabled/>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <label class="form-label" for="name">Photo Annudef:</label>
                        <img src="{{ $user->getAnnudefPictureUrl() }}" height="75px">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <x-form::input name="date_embarq" label="Date d'embarquement" type="date" :value="$user->date_embarq" disabled/>
                </div>
                <div class="col">
                    <x-form::input name="unite_id" label="Unité actuelle" type="text" :value="($user->unite)  ? $user->unite->unite_liblong : ' ' " disabled/>
                </div>               
            </div>
            <div class="row mt-4">
                <div class="col">
                    <x-form::input name="date_debarq" label="Date de débarquement" type="date" :value="$user->date_debarq" disabled/>
                </div>
                <div class="col">
                    <x-form::input name="unite_destination_id" label="Unité destination" type="text" :value="($user->unite_destination)  ? $user->unite_destination->unite_liblong : ' ' " disabled/>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    @foreach($userRole as $role)
                        <span class="badge bg-primary">{{ $role }}</span>
                    @endforeach
                </div>
                <div class="col">
                    @if(auth()->user()->IsSuperAdmin())
                        <div class="col-3 form-check form-switch mt-2">
                            <x-form::checkbox name="admin" label="SuperAdmin" value="1" :checked="$user->admin"  class="form-check-input " disabled/>
                        </div>
                    @endif
                </div>
            <div class="row mt-4">
                <x-form::textarea name="user_comment" label="Commentaire" type="textarea" :value="$user->user_comment" cols=50 rows=6 disabled/>
            </div>
        </div>
            <div class="mt-4">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Modifier</a>
                <a href="{{ route('users.index') }}" class="btn btn-default">Retour</a>
            </div>
        </div>
    </div>
</div>
@endsection

