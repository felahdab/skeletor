@extends('layouts.app-master')

@section('content')
    @if (auth()->user())
        <div><h1 class="mt-5 text-center">Bienvenue sur FFAST !</h1></div>
        <div class="d-flex m-5 ">
            <div class="bg-dark bg-opacity-10 border border-primary p-3 rounded-top text-justify">Ce site vous permet de suivre votre parcours de transformation. Il présente l’ensemble des compétences et étapes que vous devrez acquérir et valider.
            <b>C’est votre outil de travail quotidien, qui vous guidera tout au long de votre parcours.</b></div>
            <div class="bg-transparent" style="width :5%;">&nbsp;</div>
            <div class="bg-dark bg-opacity-10 border border-primary p-3 rounded-top text-justify">N’oubliez pas : <u>chacun est maître de sa formation</u>. Les tuteurs vous accompagnent et vous orientent pour vous permettre de rejoindre votre futur équipage 
            dans un état de préparation le plus abouti possible. Celui-ci dépendra avant tout de votre investissement personnel au quotidien.</div>
        </div>
        <div class="mt-5 text-center"><h4>Bonne Transformation !<h4></div>
        <div class="text-center p-2"><hr>Mon taux de transformation : <span class="display-4">{{$user->taux_de_transformation}}</span>%.<hr></div>
        <div class="mt-5 text-center">Voici quelques liens qui peuvent contribuer à votre transformation</div>
        <div class="d-flex justify-content-center mt-2">
            @foreach ($liens as $lien)
                <div class="text-center ms-3">
                    <a href="{{$lien->lien_url}}" 
                    style="text-align: center;" 
                    target="_blank">
                    <img  src="{{asset('public/images/' . $lien->lien_image)}}" 
                    style="width: 75px; height: 75px; " 
                    alt="{{$lien->lien_lib}}" /><br>{{$lien->lien_lib}}
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div>
            <img src='{!! asset("assets/images/InsigneEscouade.jpg") !!}' alt="Logo de l'escouade" style="height:450px; display: block; margin-left:auto; margin-right: auto; ">
        </div>
    @endif

@endsection

            
