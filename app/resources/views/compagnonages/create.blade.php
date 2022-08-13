@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Compagnonages</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Création compagnonage </div>
            {!! Form::open(['method' => 'POST','route' => 'compagnonages.store' ]) !!}
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='comp[comp_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control'  
                        name='comp[comp_libcourt]' 
                        id='comp[comp_libcourt]' 
                        placeholder='Libell&eacute; court' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='comp[comp_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control' 
                        name='comp[comp_liblong]' 
                        id='comp[comp_liblong]' 
                        placeholder='Libell&eacute; long' 
                        value="" >
                    </div>
                </div>
            </div>
            <div>
                <button class='btn btn-primary w-100 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
                <br>&nbsp;
            </div>
            {!! Form::close() !!}
    </div>
@endsection