@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Fonctions</h2>
        <div class='lead'>Ajout d'un stage pour la fonction {!!$fonction->fonction_libcourt !!} </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    {!! Form::open(['method' => 'GET','route' => [request()->route()->getName(), $fonction->id]]) !!}
    {!! Form::text('filter', $filter) !!}
    {!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
    {!! Form::close() !!}
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' > Ajout d'un stage </div>
        {!! Form::open(['method' => 'POST','route' => ['fonctions.ajouterstage', $fonction->id] ]) !!}
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Tache</label>
                <div>
                    <select name='stage_id' id='stage_id' class='custom-select  w-50'>
                        @foreach ($stages as $stage)
                            <option value='{{ $stage->id }}' > {{ $stage->stage_libcourt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div>
                    <button class='btn btn-primary w-100 mt-4' type='submit'>Ajouter</button>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}

    </div>
@endsection