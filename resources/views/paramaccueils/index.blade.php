@extends('layouts.app-master')

@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Page d'accueil du site</h2>
        <div class="lead">
            Gérer l'image et le texte de la page d'accueil du site            
        </div>
        
        <x-form::form method="PATCH" :action="route('paramaccueils.update')" enctype='multipart/form-data'>
        <div class="container m-2">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <div class="row card mb-2">
                        <div class="card-header col-12">PAGE ACTUELLE</div>
                        <div class="m-2">
                            <img src='{{asset("public/images/" . $paramaccueil?->paramaccueil_image)}}' style="width:250px">
                            <br><br><br>{{$paramaccueil?->paramaccueil_texte}}
                        </div>
                    </div>
                </div>
                <div class="col ms-1">
                    <div class="row card mb-2">
                        <div class="card-header text-center col-12">MODIFICATIONS</div>
                        <div class="m-2">
                            {{-- <input type='file' class='form-control' name='paramaccueil_image' id='paramaccueil_image' accept='.jpg, .jpeg, .png' for="{{ $paramaccueil->paramaccueil_image }}" > --}}
                            <x-form::input name="paramaccueil_image" label="Image" type="file" accept='.jpg, .jpeg, .png' for="{{ $paramaccueil?->paramaccueil_image }}"/>
                            <x-form::input name="paramaccueil_texte" label="Texte" type="text" :value="$paramaccueil?->paramaccueil_texte"/>
                        </div>
                        <div class="m-2">
                            <button class="btn btn-primary" type="submit">Mettre à jour</button>
                            <a href="{{ route('paramaccueils.index') }}" class="btn btn-default">Annuler</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </x-form:::form>
    </div>
@endsection