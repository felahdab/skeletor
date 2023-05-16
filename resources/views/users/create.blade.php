@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
    <div class="bg-light p-4 rounded" 
        x-data='{
            nom     : null,
            prenom  : null,
            email   : null,
            nid     : null,
            grade   : null,
            buttonid : null,

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

       @preset-this-user = "email = decode($event.detail.email);
                            nom = decode($event.detail.nom);
                            prenom = decode($event.detail.prenom);
                            nid = decode($event.detail.nid);
                            grade = decode($event.detail.grade);
                            
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
        <div class="d-flex flex-row-reverse">
            <div class="btn btn-primary" x-on:click="toggle()">Aide Annudef</div>
        </div>

        <div x-data='{ allChecked : false }'>
            <div class="container mt-4" x-data="{ buttonid : '' }">
                <div class="offcanvas offcanvas-start bg-light w-30" tabindex="-1" id="offcanvasannudef">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Recherche dans Annudef</h5>
                        <button type="button" 
                                class="btn-close text-reset" 
                                x-on:click="toggle()" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div> Effectuez une recherche dans Annudef ci-dessous </div>
                        <livewire:annudef-search mode="aide">
                    </div>
                </div>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                <input type='hidden' id='buttonid' name='buttonid' x-model="buttonid">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input value=""
                                type="email" 
                                class="form-control" 
                                name="email" 
                                placeholder="Email" 
                                x-model="email" 
                                required>
                            @if ($errors->has('email'))
                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade *</label>
                            <select class="form-control" 
                                name="grade_id"
                                id="grade_select">
                                <option value="">Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">
                                        {{ $grade->grade_liblong }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            <input value="" 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                placeholder="NOM" 
                                x-model="nom"
                                required>
                            @if ($errors->has('name'))
                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="specialite_id" class="form-label">Sp&eacute;cialit&eacute;</label>
                            <select class="form-control" 
                                name="specialite_id" >
                                <option value="">Sp&eacute;cialit&eacute;</option>
                                @foreach($specialites as $specialite)
                                    <option value="{{ $specialite->id }}"}>
                                        {{ $specialite->specialite_libcourt }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Pr&eacute;nom *</label>
                            <input value="" 
                                type="text" 
                                class="form-control" 
                                name="prenom" 
                                placeholder="Pr&eacute;nom" 
                                x-model="prenom"
                                required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="secteur_id" class="form-label">Secteur</label>
                            <select class="form-control" 
                                name="secteur_id" >
                                <option value="">Secteur</option>
                                @foreach($secteurs as $secteur)
                                    <option value="{{ $secteur->id }}">
                                        {{ $secteur->displayName() }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="matricule" class="form-label">Matricule *</label>
                            <input type="text" 
                                class="form-control" 
                                name="matricule" 
                                placeholder="Matricule">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="diplome_id" class="form-label">Brevet</label>
                            <select class="form-control" 
                                name="diplome_id" >
                                <option value="">Brevet</option>
                                @foreach($diplomes as $diplome)
                                    <option value="{{ $diplome->id }}">
                                        {{ $diplome->diplome_libcourt }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="nid" class="form-label">NID</label>
                            <input type="text" 
                                class="form-control" 
                                name="nid" 
                                placeholder="NID"
                                x-model="nid">
                         </div>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="date_embarq" class="form-label">Date d'embarquement *</label>
                            <input value="{{ date('Y-m-d') }}" 
                                type="date" 
                                class="form-control" 
                                name="date_embarq" 
                                placeholder="Date d'embarquement" required>
                        </div>
                    </div>
                    <div class="col">
                        <!--div class="mb-3">
                            <label for="unite_destination_id" class="form-label">Unité destination (informatif uniquement)</label>
                            <select class="form-control" 
                                name="unite_destination_id" >
                                <option value="">Unité destination</option>
                                @foreach($unites as $unite)
                                    <option value="{{ $unite->id }}">
                                        {{ $unite->unite_liblong }}
                                        </option>
                                @endforeach
                            </select>
                        </div-->
                        </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <input type="checkbox" name="comete" value="1">
                            <label for="comete" class="form-label">Embarqué COMETE</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <input type="checkbox" name="socle" value="1">
                            <label for="socle" class="form-label">Socle</label>
                         </div>
                    </div>
                </div>
                <div class="row">
                <!-- espace pour ajouter le commentaire-->
                    <label for='user_comment' class='form-label' style='max-width: 21.6%;'>Commentaire</label>
                    <textarea class="form-control" cols='100' rows='3' name='user_comment' id='user_comment' placeholder='Commentaire'></textarea>
                </div>
                
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
                                x-on:toggleallroles.window="$el.checked = allChecked;">
                            </td>
                            <td>{{ $role->name }}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="btn-group" role="groupe">
                    <button type="submit" 
                            class="btn btn-primary" 
                            x-on:click='buttonid ="users.index";'>Ajouter</button>
                    <button type="submit" 
                            class="btn btn-primary" 
                            x-on:click='buttonid ="users.choisirfonction";'>Ajouter et attribuer des fonctions</button>
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-default">Annuler</a>
            </form>
        </div>
</div>
    </div>
@endsection

