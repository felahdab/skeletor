@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Mises pour emploi</h2>
        <div style='text-align:right;'>* champs obligatoires </div>
 
        
        {!! Form::open(['method' => 'PATCH','route' => ['transformation::miseenvisibilite.update', $miseenvisibilite->id] ]) !!}
        <div class="row mt-4">
            <div class="col">
                <label class="form-label">Marin</label>
                <input type="text" class="form-control" name="user" disabled value="{{$user->display_name}}">
            </div>
            <div class="col">
                <label class="form-label">Unité *</label>
                <select class="form-control" name="uniteid" id="uniteid" required  value="{{$miseenvisibilite->unite_id}}">
                    <option value="">Unité</option>
                    @foreach($unites as $unite)
                        <option value="{{ $unite->id }}" {{ $miseenvisibilite->unite_id == $unite->id ? ' selected' : '' }}>
                            {{ $unite->unite_libcourt }}
                        </option>
                    @endforeach
                </select>
                <label class="form-label">Date de début</label>
                <input type="date" class="form-control" name="datedeb" id="datedeb" value="{{$miseenvisibilite->date_debut}}">
                <label class="form-label">Date de fin</label>
                <input type="date" class="form-control" name="datefin" id="datefin" value="{{$miseenvisibilite->date_fin}}">
            </div>
        </div>

        <button class='btn btn-primary ms-4 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
        <a href="{{ route('transformation::miseenvisibilite.index') }}" class="btn btn-default mt-4">Annuler</a>
        {!! Form::close() !!}
    </div>
@endsection