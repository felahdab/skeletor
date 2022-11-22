@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Modifier un marin</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
        <div class="lead">
            
        </div>

<div x-data='{ allchecked : false }' >
        <div class="container mt-4">
            {!! Form::open(['method' => 'PATCH','route' => ['users.update', $user->id], 'enctype'=>'multipart/form-data' ]) !!}
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            {!!Form::email('email', $user->email , ['class' => 'form-control', 'placeholder'=> "Adresse email", 'required']) !!}
                            @if ($errors->has('email'))
                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <select class="form-control" 
                                name="grade_id">
                                <option value="">Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" {{ $user->grade_id == $grade->id
                                            ? ' selected'
                                            : '' }}>
                                        {{ $grade->grade_liblong }}
                                        {{ $user->grade_id == $grade->id
                                            ? ' (grade actuel)'
                                            : '' }}  </option>
                                @endforeach
                            </select>
                            @if ($errors->has('grade'))
                                <span class="text-danger text-left">{{ $errors->first('grade') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            {!!Form::text('name', $user->name , ['class' => 'form-control', 'placeholder'=> "Nom", 'required']) !!}
                            @if ($errors->has('name'))
                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="specialite" class="form-label">Sp&eacute;cialit&eacute;</label>
                            <select class="form-control" 
                                name="specialite_id" >
                                <option value="">Specialite</option>
                                @foreach($specialites as $specialite)
                                    <option value="{{ $specialite->id }}" {{ $user->specialite_id == $specialite->id
                                            ? ' selected'
                                            : '' }}>
                                        {{ $specialite->specialite_libcourt }}
                                        {{ $user->specialite_id == $specialite->id
                                            ? ' (spécialité actuelle)'
                                            : '' }}  </option>
                                @endforeach
                            </select>
                            @if ($errors->has('specialite'))
                                <span class="text-danger text-left">{{ $errors->first('specialite') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Pr&eacute;nom *</label>
                            {!!Form::text('prenom', $user->prenom , ['class' => 'form-control', 'placeholder'=> "Prénom", 'required']) !!}
                            @if ($errors->has('prenom'))
                                <span class="text-danger text-left">{{ $errors->first('prenom') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="secteur" class="form-label">Secteur</label>
                            <select class="form-control" 
                                name="secteur_id" >
                                <option value="">Secteur</option>
                                @foreach($secteurs as $secteur)
                                    <option value="{{ $secteur->id }}" {{ $user->secteur_id == $secteur->id
                                            ? ' selected'
                                            : '' }}>
                                        {{ $secteur->displayName() }}
                                        {{ $user->secteur_id == $secteur->id
                                            ? ' (secteur actuel)'
                                            : '' }}  </option>
                                @endforeach
                            </select>
                            @if ($errors->has('secteur'))
                                <span class="text-danger text-left">{{ $errors->first('secteur') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="matricule" class="form-label">Matricule</label>
                            {!!Form::text('matricule', $user->matricule , ['class' => 'form-control', 'placeholder'=> "Matricule"]) !!}
                            @if ($errors->has('matricule'))
                                <span class="text-danger text-left">{{ $errors->first(matricule) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="diplome_id" class="form-label">Brevet</label>
                            <select class="form-control" 
                                name="diplome_id" >
                                <option value="">Brevet</option>
                                @foreach($diplomes as $diplome)
                                    <option value="{{ $diplome->id }}" {{ $user->diplome_id == $diplome->id
                                            ? ' selected'
                                            : '' }}>
                                        {{ $diplome->diplome_libcourt }}
                                        {{ $user->diplome_id == $diplome->id
                                            ? ' (brevet actuel)'
                                            : '' }}  </option>
                                @endforeach
                            </select>
                            @if ($errors->has('specialite'))
                                <span class="text-danger text-left">{{ $errors->first(specialite) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="nid" class="form-label">NID</label>
                            {!!Form::text('nid', $user->nid , ['class' => 'form-control', 'placeholder'=> "NID"]) !!}
                            @if ($errors->has('nid'))
                                <span class="text-danger text-left">{{ $errors->first(nid) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="unite_destination" class="form-label">Unité destination</label>
                            <select class="form-control" 
                                name="unite_destination_id" >
                                <option value="">Unité destination</option>
                                @foreach($unites as $unite)
                                    <option value="{{ $unite->id }}" @selected($user->unite_destination_id == $unite->id)>
                                        {{ $unite->unite_liblong }}
                                        {{ $user->unite_destination_id == $unite->id
                                            ? ' (unite actuelle)'
                                            : '' }}  </option>
                                @endforeach
                            </select>
                            @if ($errors->has('unite_destination'))
                                <span class="text-danger text-left">{{ $errors->first(unite_destination) }}</span>
                            @endif
                         </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="date_embarq" class="form-label">Date d'embarquement</label>
                            {!!Form::date('date_embarq', $user->date_embarq , ['class' => 'form-control', 'placeholder'=> 'Date d\'embarquement', 'required']) !!}
                            @if ($errors->has('date_embarq'))
                                <span class="text-danger text-left">{{ $errors->first(date_embarq) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" 
                                accept='.jpg, .jpeg, .png'
                                class="form-control" 
                                name="photo">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="date_debarq" class="form-label">Date de débarquement</label>
                            {!!Form::date('date_debarq', $user->date_debarq , ['class' => 'form-control', 'placeholder'=> 'Date de debarquement']) !!}
                            @if ($errors->has('date_debarq'))
                                <span class="text-danger text-left">{{ $errors->first(date_debarq) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <img src="{{url(asset('public/' . $user->photo))}}" height="75px">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <input type="checkbox" name="comete" value="1"{{ $user->comete
                                            ? ' checked'
                                            : '' }}>
                            <label for="comete" class="form-label">Embarqué COMETE</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <input type="checkbox" name="socle" value="1"{{ $user->socle
                                            ? ' checked'
                                            : '' }}>
                            <label for="socle" class="form-label">Socle</label>
                         </div>
                    </div>
                </div>
                <div class="row">
                <label for='user_comment' class='form-label'>Commentaire</label>
                    {!!Form::textarea('user_comment', $user->user_comment , ['class' => 'form-control', 'placeholder'=> "Commentaire", 'cols'=>"100", 'rows'=>"3"]) !!}
                    @if ($errors->has('user_comment'))
                        <span class="text-danger text-left">{{ $errors->first('user_comment') }}</span>
                    @endif                
                </div>
                
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

                {!! Form::button('Mettre à jour', ['class'=>'btn btn-primary', 'type'=>'submit']) !!}
                {!! link_to_route('users.index', 'Annuler', [], ['class' => 'btn btn-default']) !!}
            {!! Form::close() !!}
        </div>

    </div>
</div>
@endsection

