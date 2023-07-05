<div style='width:100%; display:""; '
    wire:init="triggerLoad">


    <div class="container">
        <div class="row card">
            <div class="col-12 card-header text-center">
                <div class="row">
                    <div class="col-11"><h1>{{$user->display_name}}</h1></div>
                    <div class="col-1">
                        <a href="{{ route('transformation::transformation.fichebilanpdf', $user->id) }}" class="btn btn-default" title="Imprimer"><x-bootstrap-icon iconname='printer.svg' /></a>
                        {{--  --}}
                    </div>
                </div>
            </div>    
            <div class="container">
                <div class="row justify-content-between mt-2 mb-2">
                    <div class="col-2">
                        @if($readyToLoad)<img src="{{ $user->getAnnudefPictureUrl() }}" width="150px">@endif
                    </div>
                    <div class="col-4">
                        <div class="text-center mb-3 mt-3"><h1>{{round($user->taux_de_transformation, 2)}}%</h1></div>
                        <div class="card "><div class=" m-2">
                            <div><b>Sp&eacute;cialit&eacute; : </b>{{$user->displaySpecialite()}}</div>
                            <div><b>Secteur : </b>{{$user->displaySecteur()}}</div>
                            <div><b>Date d'embarquement : </b>{{$user->date_embarq}}</div>
                            <div><b>Unité destination : </b>{{$user->displayDestination()}}</div>     
                        </div></div>           
                    </div>
                    <div class="col-6 ">
                        @if($readyToLoad)
                        <div class="row card mb-2">
                            @if ($user->getTransformationManager()->fonctionAQuai() != null)
                                <div class="card-header"><b>Fonction(s) de service à quai</b></div>
                                <div class="container ">
                                    @foreach($user->getTransformationManager()->fonctionAQuai() as $fonctionAquai)
                                    <div class="row">
                                        <div class="col">{{$fonctionAquai->fonction_libcourt}}</div>
                                        <div class="col">{{ $fonctionAquai->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="row card mb-2">
                            @if ($user->getTransformationManager()->fonctionAMer() != null)
                                <div class="card-header "><b>Fonction(s) de service à la mer</b></div>
                                <div class="container ">
                                    @foreach($user->getTransformationManager()->fonctionAMer() as $fonctionAmer)
                                    <div class="row">
                                        <div class="col">{{$fonctionAmer->fonction_libcourt}}</div>
                                        <div class="col">{{ $fonctionAmer->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>                    
                        <div class="row card mb-2">
                            @if ($user->getTransformationManager()->fonctionsMetier() != null)
                                <div class="card-header "><b>Fonction(s) métier</b></div>
                                <div class="container ">
                                    @foreach($user->getTransformationManager()->fonctionsMetier() as $fonctionmetier)
                                    <div class="row">
                                        <div class="col">{{$fonctionmetier->fonction_libcourt}}</div>
                                        <div class="col">{{ $fonctionmetier->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>                    
                        @endif                                
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-6"><div class="me-1">
                <div class="row card mb-2">
                    @if($readyToLoad)
                        @if (isset($listcomp))
                        <div class="card-header col-12 text-center"><b>COMPAGNONNAGES</b></div>
                        <div class="container ">
                            @foreach($listcomp as $comp)
                                <div class="row">
                                    <div class="col-6">{{$comp->comp_libcourt}}</div>
                                    @php 
                                        $pourcentage = $user->getTransformationManager()->taux_de_transformation(null, $comp, null, null);
                                        if ($pourcentage == 100)
                                            $color = 'green';
                                        elseif ($pourcentage >= 70 )
                                            $color = 'purple';
                                        elseif ($pourcentage >= 35)
                                            $color = 'Goldenrod';
                                        else
                                            $color = 'red';                                    
                                    @endphp                                    
                                    <div class="col-6">
                                        <span style="color:{{$color}};">{{round($pourcentage,2)}} %</span>
                                    </div>
                                </div>
                                @endforeach
                        </div>
                        @endif
                    @endif
                </div> 
            </div></div>
           
            <div class="col-sm-6"><div class="ms-1">
                <div class="row card mb-2">
                    @if($readyToLoad)
                        @if (isset($liststage))
                        <div class="card-header col-12"><b>STAGES</b></div>
                        <div class="container ">
                            @foreach($liststage as $stage)
                                <div class="row">
                                    <div class="col-6">{{$stage->stage_libcourt}}</div>
                                    <div class="col-6">
                                        @if ($datvalid=$user->getTransformationManager()->dateDeValidationDuStage($stage) )
                                            @if($datvalid> date('Y-m-d'))
                                                <span style="color:purple;">INSCRIT <small>(session du {{$datvalid}})</small></span>
                                            @else
                                                <span style="color:green;">VALIDE ({{$datvalid}})</span>
                                            @endif
                                        @else
                                            <span style="color:red;">NON VALIDE</span>
                                        @endif                                      
                                    </div>
                              </div>
                            @endforeach
                        </div>
                        @endif
                    @endif
                </div> 
            </div> </div>
        </div>
    </div>
</div>
