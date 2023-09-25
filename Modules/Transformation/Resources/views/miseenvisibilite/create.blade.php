@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Mises pour emploi</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
 
        
        {!! Form::open(['method' => 'POST','route' => 'transformation::miseenvisibilite.store' ]) !!}
        <div class="row mt-4">
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
                <label class="form-label">Date de début *</label>
                <input type="date" class="form-control" name="datedeb" id="datedeb" required>
                <label class="form-label">Date de fin *</label>
                <input type="date" class="form-control" name="datefin" id="datefin" required>
            </div>
        </div>

        <button class='btn btn-primary ms-4 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Créer</button>
        <a href="{{ route('transformation::miseenvisibilite.index') }}" class="btn btn-default mt-4">Annuler</a>
        {!! Form::close() !!}
    </div>
@endsection