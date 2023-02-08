@extends('layouts.app-master')

@section('content')
    @if (auth()->user())
 
        <div>
            <h1 class="mt-5 text-center">Bienvenue sur FFAST !</h1><br><hr>
        </div>    
        <div class="container">
            <div class="row">
                <div class="col-md-3 mt-5">
                <p style="text-align:justify">Ce site vous permet de suivre votre parcours de transformation. Il présente l’ensemble des compétences et étapes que vous devrez acquérir et valider.<br><br>
                    <b>C’est votre outil de travail quotidien, qui vous guidera tout au long de votre parcours.</b></p><br>
                    <p class="text-center"><br><a href="{{ route('transformation.monlivret') }}" class="btn btn-warning btn-lg">Mon livret de transformation</a></p>
                </div>
                <div class="col-md-6 mt-5">
                    <div><p class="text-center"><font size="6%">Taux de transformation</font></p></div>
                    <div class="display-2 mt-4"><p class="text-center">{{$user->taux_de_transformation}}&nbsp;%</p></div>
                    <p class="text-center"><br><a href="{{ route('transformation.maprogression') }}" class="btn btn-primary btn-lg ">Ma progression</a></p>
                </div>
                <div class="col-md-3 mt-5">
                    <p style="text-align:justify"><u>N’oubliez pas :</u> <br>chacun est maître de sa formation.<br> Les tuteurs vous accompagnent et vous orientent pour vous permettre de rejoindre votre futur équipage
                    dans un état de préparation le plus abouti possible. Celui-ci dépendra avant tout de votre investissement personnel au quotidien.</p>
                    <p class="text-center"><br><a href="{{ route('transformation.mafichebilan') }}" class="btn btn-secondary btn-lg">Ma fiche bilan</a></p>
                </div>
            </div>
        </div>    
        <br>
        <div style="text-align:center;">Voici quelques liens qui peuvent contribuer à votre transformation<br></div>
            <div class="d-flex justify-content-center mt-5">
            @foreach ($liens as $lien)
                <div class="text-center ms-3">
                    <a href="{{$lien->lien_url}}"
                    style="text-align: center;"
                    target="_blank">
                    <img  src="{{url(asset('public/images/' . $lien->lien_image))}}"
                    style="width: 65px; height: 65px; "
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

            
