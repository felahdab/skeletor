@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Partage de dossier</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
 
        <x-form::form method="POST" :action="route('transformation::miseenvisibilite.store')">
        <div class="row mt-4"
        x-data='{
            hideshowdates() {
                if (document.getElementById("permanent").checked){
                    document.getElementById("datedeb").value = null;
                    document.getElementById("datedeb").disabled = true;
                    document.getElementById("datedeb").required = false;
                    document.getElementById("datefin").value = null;
                    document.getElementById("datefin").disabled = true;
                    document.getElementById("datefin").required = false;
                }
                else{
                    document.getElementById("datedeb").disabled = false;
                    document.getElementById("datedeb").required = true;
                    document.getElementById("datefin").disabled = false;
                    document.getElementById("datefin").required = true;
                }
            },
        }'>
            <div class="col">
                <label class="form-label">Marin(s) *</label>
                <select class="form-control" multiple  required size="7" name="users[]" id="users[]">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name}}&nbsp;{{$user->prenom }}
                        </option>
                    @endforeach
                </select>
                <p style="font-size: smaller;">Selectionnez plusieurs marins en maintenant la touche Ctrl enfoncée.</p>
            </div>
            <div class="col">
                <label class="form-label">Unité *</label>
                <select class="form-control" name="uniteid" id="uniteid" required>
                    <option value="">Unité</option>
                    @foreach($unites as $unite)
                        <option value="{{ $unite->id }}">
                            {{ $unite->unite_libcourt }}
                        </option>
                    @endforeach
                </select>
                <div class="row"><div class="col-12">&nbsp;<br>&nbsp;</div></div>
                <div class="row"><div class="col-12">Durée *</div></div>
                <div class="row">
                    <div class="col-2">
                        <label class="form-label">Permanent</label>
                        <div class="form-check form-switch mt-2">
                            <x-form::checkbox name="permanent" value="1" x-on:click="hideshowdates()" />                        
                        </div>       
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4">
                        <label class="form-label">Date de début</label>
                        <x-form::input name="datedeb" type="date" required/>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Date de fin</label>
                        <x-form::input name="datefin" type="date" required/>
                    </div>
                </div>
            </div>
        </div>

        <button class='btn btn-primary ms-4 mt-4' type='submit' id='btncreerobj' name='btncreerobj'>Créer</button>
        <a href="{{ route('transformation::miseenvisibilite.index') }}" class="btn btn-default mt-4">Annuler</a>
        </x-form::form>
    </div>
@endsection