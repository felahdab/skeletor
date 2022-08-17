@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Attribution des fonctions à l'utilisateur</h1>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        <div class='card-header' > Utilisateur </div>
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='fonction[fonction_libcourt]' class='col-sm-5 col-form-label'> Nom</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control'  
                        name='nom' 
                        id='nom' 
                        value="{{ $user->name }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction[fonction_libcourt]' class='col-sm-5 col-form-label'> Prénom</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control'  
                        name='prenom' 
                        id='prenom' 
                        value="{{ $user->prenom }}" >
                    </div>
                </div>
            </div>
        <div class="container mt-4">
                
            <div style='padding-left: 15px;'>
                <div class='card-header ml-n3 mr-n4 mb-3' >Fonction(s) attribu&eacute;e(s)</div>
                
                @php $count = 1 @endphp
                @foreach ($user->fonctions()->get() as $fonction)
                <div class='cadressobj'>
                    <div class='form-group row' >
                        <label class='col-sm-5 col-form-label '>Fonction </label>
                    </div>
                    <div class='form-group row' >
                        <label class='col-sm-5 col-form-label '>Libelle court</label>
                        <div class='col-sm-5'>
                            <input type='text' 
                            class='form-control' 
                            name='fonction_libcourt' 
                            id='fonction_libcourt' 
                            placeholder='Libelle court' 
                            value='{{ $fonction->fonction_libcourt }}'>
                        </div>
                    </div>
                    <div class='form-group row' >
                        <label class='col-sm-5 col-form-label '>Libelle long</label>
                        <div class='col-sm-5'>
                            <input type='text' 
                            class='form-control' 
                            name='fonction_liblong' 
                            id='fonction_liblong' 
                            placeholder='Libelle long' 
                            value='{{ $fonction->fonction_liblong }}'>
                        </div>
                    </div>
                    <div class='form-group row' >
                        <label class='col-sm-5 col-form-label '>Type de fonction</label>
                        <div class='col-sm-5'>
                            <input type='text' 
                            class='form-control' 
                            name='typefonction' 
                            id='typefonction' 
                            placeholder='Type de fonction' 
                            value='{{ $fonction->type_fonction()->get()->first()->typfonction_libcourt }}'>
                        </div>
                    </div>
                    {!! Form::open(['method' => 'POST','route' => ['users.retirerfonction', $user->id]]) !!}
                    <input type='hidden' id='fonction_id' name='fonction_id' value='{{ $fonction->id }}'>
                    {!! Form::button('Retirer cette fonction', ['type'=> 'submit', 'class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
                @php $count = $count +1 @endphp
                @endforeach
                
            </div>

            {!! Form::open(['method' => 'POST','route' => ['users.attribuerfonction', $user->id]]) !!}
            <label for="fonction" class="form-label">Fonction</label>
            <select class="form-control" 
                name="fonction_id" required>
                <option value="0">Fonction a attribuer</option>
                @foreach($fonctions as $fonction)
                    <option value="{{ $fonction->id }}">
                        {{ $fonction->fonction_liblong }}
                        </option>
                @endforeach
            </select>

            {!! Form::button('Attribuer cette fonction', ['type'=> 'submit', 'class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

    </div>
@endsection