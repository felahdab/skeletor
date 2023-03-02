@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
 <div class="bg-light p-4 rounded">
    <h1>Utilisateurs</h1>
    <div class="lead">
        Valider une demande d'accès
    </div>

<div x-data='{ allChecked : false }'>

    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="8%">Nom</th>
                <th scope="col" width="8%">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">Unité</th>
                <th scope="col">Titre</th>
                <th scope="col">Grade</th>
                <th scope="col">Grade court</th>
            </tr>
            </thead>
            <tbody>
                    <tr>
                        <th scope="row">{{ $mcuser->id }}</th>
                        <td>{{ $mcuser->name }}</td>
                        <td>{{ $mcuser->prenom }}</td>
                        <td>{{ $mcuser->email }}</td>
                        <td>{{ $mcuser->main_department_number }}</td>
                        <td>{{ $mcuser->personal_title }}</td>
                        <td>{{ $mcuser->rank }}</td>
                        <td>{{ $mcuser->short_rank }}</td>
                    </tr>
            </tbody>
        </table>
        
    </div>
    <div>
    @if ($cpte_exist)
        <!-- compte existe déjà -->
        <p class="lead">Ce compte existe déjà mais n'est pas accessible. Que voulez vous faire ?</p>
        <a href="{{ route('mindefconnect.conservcpte', $mcuser) }}" class="btn btn-primary">Rouvrir le compte <u><strong>AVEC</strong></u> les données associées</a>
        <a href="{{ route('mindefconnect.effacecpte', $mcuser) }}" class="btn btn-secondary">Rouvrir le compte <u><strong>SANS</strong></u> les données associées</a> 
        <a href="{{ route('mindefconnect.index') }}" class="btn ">Retour</a>
    @else
        <!-- compte à créer -->
        <div class="container mt-4">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input value="{{$mcuser->email}}"
                                type="email" 
                                class="form-control" 
                                name="email" 
                                placeholder="Email address" required> 
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
                                    <option value="{{ $grade->id }}" @selected($possibleGrade!= null and $grade->id  == $possibleGrade->id) >
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
                            <label for="name" class="form-label">Nom</label>
                            <input value="{{$mcuser->name}}" 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                placeholder="Name" required>

                            @if ($errors->has('name'))
                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="specialite_id" class="form-label">Specialite</label>
                            <select class="form-control" 
                                name="specialite_id" >
                                <option value="">Specialite</option>
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
                            <label for="prenom" class="form-label">Prenom</label>
                            <input value="{{$mcuser->prenom}}" 
                                type="text" 
                                class="form-control" 
                                name="prenom" 
                                placeholder="Prenom" required>
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
                            <label for="date_embarq" class="form-label">Date d'embarquement</label>
                            <input value="{{date('Y-m-d')}}" 
                                type="date" 
                                class="form-control" 
                                name="date_embarq" 
                                placeholder="Date d'embarquement" required>
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
               
                <label for="roles" class="form-label">Attribuer des roles</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" name="all_roles" x-on:click="allChecked = !allChecked; $dispatch('toggleallroles');"></th>
                        <th scope="col" width="20%">Nom</th>
                    </thead>

                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                name="role[{{ $role->name }}]"
				value="{{ $role->name }}"
                                x-on:toggleallroles.window="$el.checked = allChecked;"
                                class='role' @checked($role->name == "user")>
                            </td>
                            <td>{{ $role->name }}</td>
                        </tr>
                    @endforeach
                </table>

                <button type="submit" class="btn btn-primary">Enregistrer l'utilisateur</button>
                <a href="{{ route('mindefconnect.index') }}" class="btn btn-default">Retour</a>
            </form>
        </div>
    @endif
    </div>    
</div>
</div>
@endsection

