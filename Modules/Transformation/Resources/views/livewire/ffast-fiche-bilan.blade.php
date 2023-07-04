<div style='width:100%; display:""; '
    wire:init="triggerLoad">


    <div class="container">
        <div class="row card">
            <div class="col-12 card-header text-center"><h1>{{$user->display_name}}</h1></div>
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
        <div class="d-flex flex-row justify-content-center">
            <div class="p-2">
                <div class="row card mb-2">
                    @if (isset($listcomp))
                    <div class="card-header "><b>COMPAGNONNAGES</b></div>
                    <div class="container ">
                        @foreach($listcomp as $comp)
                            <div class="row">
                                <div class="col">{{$comp->comp_libcourt}}</div>
                                @php 
                                    $pourcentage = $user->getTransformationManager()->taux_de_transformation(null, $comp, null, null);
                                @endphp
                                <x-ffast-progression-div :pourcentage="$pourcentage" height="whatever" class="col"/>
                            </div>
                            @endforeach
                    </div>
                    @endif
                </div> 
            </div>
            <div class="p-2">STAGES</div>
            

        </div>

        
        
        
        
        
        
    </div>


    

    <table class=' mb-2 ' id ='ficheDeSynthese '  style='width: 100%; height: 95%; '>
  
                <tr>
                    <!-- Entete fiche synthese -->
                    <th colspan='2' class='text-center'></th>
                    <th colspan='2' class='text-center'></th>
                </tr>

        </thead>
        @if($readyToLoad)
            <tbody style='border: 1px solid #C3C3C3;'>
                @if (isset($listcomp))
                    @foreach($listcomp as $comp)
                        <tr style='border : 1px solid black;' >
                            @if ($comp == null)
                                <td style='width:25%;'></td>
                                <td style='width:25%;'></td>
                            @else
                                <td style='width:25%;'>{{$comp->comp_libcourt}}</td>
                                @php 
                                    $pourcentage = $user->getTransformationManager()->taux_de_transformation(null, $comp, null, null);
                                @endphp
                                <x-ffast-progression-div :pourcentage="$pourcentage" height="whatever" style="td"/>
                            @endif
                            
                            @php $stage = $liststage[$loop->index] ; @endphp
                            @if ($stage == null)
                                <td style='width:25%;'></td>
                                <td style='width:25%;'></td>
                            @else
                                <td style='width:25%;'>{{$stage->stage_libcourt}}</td>
                                @if ($datvalid=$user->getTransformationManager()->dateDeValidationDuStage($stage) )
                                    @if($datvalid> date('Y-m-d'))
                                        <x-ffast-progression-div :pourcentage="50" height="whatever" style="td"  text="INSCRIT"/>
                                    @else
                                        <x-ffast-progression-div :pourcentage="100" height="whatever" style="td"  text="VALIDE"/>
                                    @endif
                                @else
                                    <x-ffast-progression-div :pourcentage="0" height="whatever" style="td" text="NON VALIDE"/>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        @endif
    </table>
</div>
