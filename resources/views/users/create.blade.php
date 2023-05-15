@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')
    <div class="  p-4 rounded" 
        x-data='{
            nom     : null,
            prenom  : null,
            email   : null,
            nid     : null,
            grade   : null,

            aideannudef  : false ,
            offcanvas_el : null ,
            offcanvas    : null ,
            grade_select : null,
            
            toggle() {
                this.aideannudef = ! this.aideannudef;
                this.aideannudef ? this.offcanvas.show() : this.offcanvas.hide() ;
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
                            }"

        x-init='
            offcanvas_el = document.getElementById("offcanvasannudef");
            offcanvas = new bootstrap.Offcanvas(offcanvas_el, {backdrop: false});
            grade_select = document.getElementById("grade_select");'>

        <h2>Ajouter un marin</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
<div x-data='{ allChecked : false }'>
        <div class="container mt-4" x-data="{ buttonid : '' }">
            <x-form::form method="POST" action="" enctype='multipart/form-data'>
                <input type='hidden' id='buttonid' name='buttonid' x-model="buttonid">
                @csrf
                <div class="row mt-4">
                    <div class="col">
                        <x-form::input name="email" label="Email *" placeholder="Email..." type="email" required/>
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
                        <x-form::input name="name" label="Nom *" placeholder="Nom..." type="text" required/>
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
                        <x-form::input name="prenom" label="Prénom *" placeholder="Prénom..." type="text" required/>
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
                       <x-form::input name="nid" label="NID" placeholder="NID..." type="text" />
                    </div>
                    <div class="col">
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
                    <x-form::textarea name="user_comment" label="Commentaire" placeholder="Commentaire..." type="textarea" cols=100 rows=3/>
                </div>
                
                <div class="row mt-4" x-data='{ allchecked : false }' >
                    <label for="roles" class="form-label">Attribuer des r&ocirc;les</label>
                    <table class="table table-striped">
                        <thead>
                            <th scope="col" width="1%"><input type="checkbox" x-on:click="allChecked = ! allChecked; $dispatch('toggleallroles');"></th>
                            <th scope="col" width="20%">Sélectionner les r&ocirc;les</th>
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
    </div>
@endsection

