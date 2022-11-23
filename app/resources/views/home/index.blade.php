@extends('layouts.app-master')

@section('content')
    @if (auth()->user())
        <div><h1 class="mt-5 text-center">Bienvenue sur FFAST !</h1></div>
        <div class="d-flex m-4 ">
            <div class="bg-dark bg-opacity-10 p-3 text-justify" style="border-radius: 25px;">
                Ce site vous permet de suivre votre parcours de transformation. Il présente l’ensemble des compétences et étapes que vous devrez acquérir et valider.
                <b>C’est votre outil de travail quotidien, qui vous guidera tout au long de votre parcours.</b>
                <p class="text-center"><br><a href="{{ route('transformation.monlivret') }}" class="btn btn-warning btn-lg">Mon livret de transformation</a></p>
            </div>
            <div class="bg-transparent" style="width :5%;">&nbsp;</div>
            <div class=" bg-dark bg-opacity-10 p-3 text-justify" style="border-radius: 25px;">
                N’oubliez pas : <u>chacun est maître de sa formation</u>. Les tuteurs vous accompagnent et vous orientent pour vous permettre de rejoindre votre futur équipage 
                dans un état de préparation le plus abouti possible. Celui-ci dépendra avant tout de votre investissement personnel au quotidien.
                <p class="text-center"><br><a href="{{ route('transformation.mafichebilan') }}" class="btn btn-secondary btn-lg">Ma fiche bilan</a></p>
            </div>
        </div>
        <div class="d-flex m-4">
            <div class="bg-dark bg-opacity-10 p-3 text-center" style="border-radius: 25px;width:35%;">
                <div>Mon taux de transformation</div>
                <div class="display-4 mt-4">{{$user->taux_de_transformation}}&nbsp;%</div>
                <br><a href="{{ route('transformation.maprogression') }}" class="btn btn-primary btn-lg">Ma progression</a>
            </div>
            <div class="bg-transparent" style="width :5%;">&nbsp;</div>
            <div class="bg-dark bg-opacity-10 p-3 text-" style="border-radius: 25px;width:60%;">
                <div class="text-center">Voici quelques liens qui peuvent contribuer à votre transformation<br></div>
                <div class="d-flex justify-content-center mt-4">
                    @foreach ($liens as $lien)
                        <div class="text-center ms-3">
                            <a href="{{$lien->lien_url}}" 
                            style="text-align: center;" 
                            target="_blank">
                            <img  src="{{url('public/images/' . $lien->lien_image)}}" 
                            style="width: 65px; height: 65px; " 
                            alt="{{$lien->lien_lib}}" /><br>{{$lien->lien_lib}}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-5 text-center"><h4>Bonne Transformation !<h4></div>
        <div class="text-center"><img src="{!! asset("assets/images/profilfremm.png") !!}" height="100px" ></div>        
    @else
        <div>
            <img src='{!! asset("assets/images/InsigneEscouade.jpg") !!}' alt="Logo de l'escouade" style="height:450px; display: block; margin-left:auto; margin-right: auto; ">
        </div>
    @endif

@endsection

            
