@extends('layouts.app-master')

@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded" 
        x-data='{
            nom     : null,
            prenom  : null,
            email   : null,
            nid     : null,
            grade   : null,
            buttonid : null,

            offcanvas_el : null,
            offcanvas    : null,
            grade_select : null,
            
            hide() {
                this.offcanvas.hide();
            },

            show() {
                this.offcanvas.show();
            },

            decode(str){
                let txt = document.createElement("textarea");
                txt.innerHTML = str;
                return txt.value;
            }
        }'

       @preset-this-user = "email  = decode($event.detail.email);
                            nom    = decode($event.detail.nom);
                            prenom = decode($event.detail.prenom);
                            nid    = decode($event.detail.nid);
                            grade  = decode($event.detail.grade);
                            
                            for (i=0; i < grade_select.options.length; i++){
                                var option = grade_select.options[i]; 
                                console.log(grade.trim().toUpperCase());
                                if (grade.trim().toUpperCase() == option.childNodes[0].textContent.trim().toUpperCase()) 
                                {
                                    option.selected = true;
                                }
                            };
                            hide();"

        x-init='
            offcanvas_el = document.getElementById("offcanvasannudef");
            offcanvas_el.addEventListener("hidden.bs.offcanvas", event => {
                aideannudef = false;
            });
              
            offcanvas = new bootstrap.Offcanvas(offcanvas_el, {backdrop: true});
            grade_select = document.getElementById("grade_id");'>

        <h2>Ajouter un marin</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
        <div class="d-flex flex-row-reverse">
            <div class="btn btn-primary" x-on:click="show()">Aide Annudef</div>
        </div>

        <div x-data='{ allChecked : false }'>
            <div class="container mt-4" x-data="{ buttonid : '' }">
                <div class="offcanvas offcanvas-start bg-light w-30" tabindex="-1" id="offcanvasannudef">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Recherche dans Annudef</h5>
                        <button type="button" 
                                class="btn-close text-reset" 
                                x-on:click="hide()" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div> Effectuez une recherche dans Annudef ci-dessous </div>
                        <livewire:annudef-search mode="aide">
                    </div>
                </div>
            </div>

            <x-form::form method="POST" action="">
                <input type='hidden' id='buttonid' name='buttonid' x-model="buttonid">
                
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="email" label="Email *" placeholder="Email..." type="email" x-model="email" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="grade_id" 
                            :models="$grades" 
                            label="Grade *" 
                            key-attribute="id" 
                            value-attribute="grade_liblong"
                            required>
                            <option value="">Grade</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="name" label="Nom *" placeholder="Nom..." type="text" x-model="nom" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="specialite_id" 
                                :models="$specialites" 
                                label="Spécialité" 
                                key-attribute="id" 
                                value-attribute="specialite_libcourt">
                                <option value="">Specialite</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="prenom" label="Prénom *" placeholder="Prénom..." type="text" x-model="prenom" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="secteur_id" 
                            :models="$secteurs" 
                            label="Secteur" 
                            key-attribute="id" 
                            value-attribute="secteur_libcourt">
                            <option value="">Secteur</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="matricule" label="Matricule *" placeholder="Matricule..." type="text" required/>
                    </div>
                    <div class="col">
                        <x-form::model-select name="diplome_id" 
                            :models="$diplomes" 
                            label="Brevet" 
                            key-attribute="id" 
                            value-attribute="diplome_libcourt">
                            <option value="">Brevet</option>
                        </x-form::model-select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                       <x-form::input name="nid" label="NID" placeholder="NID..." type="text" x-model="nid"/>
                    </div>
                    <div class="col  ms-4">
                        @if(auth()->user()->IsSuperAdmin())
                            <div class="row mt-4">
                                <div class="col-3 form-check form-switch">
                                    <x-form::checkbox name="admin" value="0" label="SuperAdmin" class="form-check-input "/>
                                </div>
                                <div class="col">
                                    <span class="text-danger"><x-bootstrap-icon iconname='exclamation-triangle.svg' /></span>
                                    Si vous cochez la case SuperAdmin, l'utilisateur aura tous les droits sur l'application, quels que soient les rôles séléctionnés.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="date_embarq" label="Date d'embarquement *" type="date" required/>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <x-form::checkbox name="comete" value="1" label="Embarqué COMETE" />
                    </div>
                    <div class="col">                        
                        <x-form::checkbox name="socle" value="1" label="Socle" />
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="row" x-data='{ allchecked : false }' >
                            <table class="table w-75">
                                <thead>
                                    <th scope="col" width="1%"><input type="checkbox" x-on:click="allChecked = ! allChecked; $dispatch('toggleallroles');"></th>
                                    <th scope="col" width="20%">Sélectionner les r&ocirc;les à attribuer</th>
                                </thead>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>
                                            <input type="checkbox" 
                                            name="role[{{ $role->name }}]"
                                            value="{{ $role->name }}"
                                            class='role'
                                            x-on:toggleallroles.window="$el.checked = allChecked;">
                                        </td>
                                        <td>{{ $role->name }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <x-form::textarea name="user_comment" label="Commentaire" placeholder="Commentaire..." type="textarea" cols=50 rows=12/>
                    </div>
                </div>
                <div class="row mt-4">
                    
                </div>
                
                <div class="btn-group" role="groupe">
                    <button type="submit" 
                            class="btn btn-primary" 
                            x-on:click='buttonid ="users.index";'>Ajouter</button>
                    <button type="submit" 
                            class="btn btn-primary" 
                            x-on:click='buttonid ="users.choisirfonction";'>Ajouter et attribuer des fonctions</button>
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-default">Annuler</a>
            </x-form:::form>
        </div>
    </div>
@endsection

