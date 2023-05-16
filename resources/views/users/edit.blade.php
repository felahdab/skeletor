@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Modifier un marin</h2>
        <div style='text-align:right;'>* champs obligatoires </div>

    <div >
        <div class="container mt-4">
            <x-form::form method="PATCH" :action="route('users.update', $user->id)" enctype='multipart/form-data'>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="email" label="Email *" placeholder="Email..." type="email" :value="$user->email" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="grade_id" 
                            :models="$grades" 
                            label="Grade *" 
                            key-attribute="id" 
                            value-attribute="grade_liblong"
                            :value="$user->grade"
                            required>
                            <option value="">Grade</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="name" label="Nom *" placeholder="Nom..." type="text" :value="$user->name" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="specialite_id" 
                                :models="$specialites" 
                                label="Spécialité" 
                                key-attribute="id" 
                                value-attribute="specialite_libcourt"
                                :value="$user->specialite">
                                <option value="">Specialite</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="prenom" label="Prénom *" placeholder="Prénom..." type="text" :value="$user->prenom" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="secteur_id" 
                            :models="$secteurs" 
                            label="Secteur" 
                            key-attribute="id" 
                            value-attribute="secteur_libcourt"
                            :value="$user->secteur">
                            <option value="">Secteur</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="matricule" label="Matricule *" placeholder="Matricule..." type="text" :value="$user->matricule" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="diplome_id" 
                            :models="$diplomes" 
                            label="Brevet" 
                            key-attribute="id" 
                            value-attribute="diplome_libcourt"
                            :value="$user->diplome">
                            <option value="">Brevet</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="nid" label="NID" placeholder="NID..." type="text" :value="$user->nid"/>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="date_embarq" label="Date d'embarquement *" type="date" :value="$user->date_embarq" required/>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <img src="{{ $user->getAnnudefPictureUrl() }}" height="75px">
                        </div>
                    </div>                        
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="date_debarq" label="Date de débarquement *" type="date" :value="$user->date_debarq"/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="unite_destination_id" 
                            :models="$unites" 
                            label="Unité destination" 
                            key-attribute="id" 
                            value-attribute="unite_liblong"
                            :value="$user->unite_destination">
                            <option value="">Unité destination</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::checkbox name="comete" value="1" :checked="$user->comete" label="Embarqué COMETE" />
                    </div>
                    <div class="col">
                        <x-form::checkbox name="socle" value="1" :checked="$user->socle" label="Socle" />
                    </div>
                </div>
                <div class="row mt-4">
                    <x-form::textarea name="user_comment" label="Commentaire" placeholder="Commentaire..." type="textarea" :value="$user->user_comment" cols=100 rows=3/>
                </div>
                <div class="row mt-4">
                    <div x-data='{ allchecked : false }' >
                        <label for="roles" class="form-label">Attribuer des rôles</label>
                        <table class="table table-striped">
                            <thead>
                                <th scope="col" width="1%"><input type="checkbox" x-on:click="allchecked = !allchecked; $dispatch('toggleallroles');">Tous</button></th>
                                <th scope="col" width="20%">Sélectionner les rôles</th>
                            </thead>

                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <input type="checkbox" 
                                        name="role[{{ $role->name }}]"
                                        value="{{ $role->name }}"
                                        class='role'
                                        x-on:toggleallroles.window="$el.checked = allchecked;"
                                        {{ in_array($role->name, $userRole) 
                                            ? 'checked'
                                            : '' }}
                                        >
                                    </td>
                                    <td>{{ $role->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                        @if ($errors->has('role'))
                            <span class="text-danger text-left">{{ $errors->first(role) }}</span>
                        @endif
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Mettre à jour</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Annuler</a>
            </x-form:::form>
        </div>

    </div>
</div>
@endsection

