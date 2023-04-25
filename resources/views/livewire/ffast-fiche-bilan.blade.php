<div style='width:100%; display:""; '
    wire:init="triggerLoad">

    <table class='fiche-de-synthese mb-2 ' 
    id ='ficheDeSynthese ' 
    style='width: 100%; height: 95%; '>
        <thead style='border: 1px solid #C3C3C3; '>
            <tr class='enTeteFicheSynthese'>
                <td colspan='2'><h1>{{$user->display_name}}</h1></td>
                <td></td>
                <td rowspan='4 '>@if($readyToLoad)<img src="{{ $user->getAnnudefPictureUrl() }}" width="150px">@endif</td>
            </tr>

            <tr class='enTeteFicheSynthese '>
                <td colspan='2 ' 
                class='text-right'>Sp&eacute;cialit&eacute; :</td>
                <td>{{$user->displaySpecialite()}}</td>
            </tr>
            <tr class='enTeteFicheSynthese '> <!-- Date d'embarquement -->
                <td colspan='2' class='text-right'>Date d'embarquement :</td>
                <td id='tdDateEmbarquement'>{{$user->date_embarq}}</td>
            </tr>
            <tr class='enTeteFicheSynthese'>
                <!-- Pourcentage transformation -->
                <td colspan='2' class='text-right'>Taux de transformation :</td>
                <td id='tdTauxTransformation' class='text-left'>{{round($user->taux_de_transformation, 2)}}%</td>
                <td></td>
            </tr>
            @if($readyToLoad)
                @if ($user->getTransformationManager()->fonctionAQuai() != null)
                @foreach($user->getTransformationManager()->fonctionAQuai() as $fonctionAquai)
                    <tr class='enTeteFicheSynthese'>
                        <!-- Fonction de service à quai -->
                        <td colspan='2' class='text-right'>Fonction de service à quai :</td>
                        <!------------------------------------------------->
                        <!-- un user n'a pas forcement de fonction a quai-->
                        <!-- mail il peut aussi en avoir plusieur-->
                        <!------------------------------------------------->
                        <td id='tdFonctionServiceQuai' class='text-left'>{{$fonctionAquai->fonction_libcourt}}</td>
                        <td id='tdFonctionServiceQuaiLache'>{{ $fonctionAquai->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</td>
                    </tr>
                @endforeach
                @endif
                <tr>
                    <td colspan='4'>&nbsp;</td>
                </tr>
                <tr>
                    <!-- Entete fiche synthese -->
                    <th colspan='2' class='text-center'>COMPAGNONNAGES</th>
                    <th colspan='2' class='text-center'>STAGES</th>
                </tr>
            @endif
        </thead>
        @if($readyToLoad)
            <tbody>
                @if (isset($listcomp))
                    @foreach($listcomp as $comp)
                        <tr>
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
                                @if ($user->getTransformationManager()->aValideLeStage($stage))
                                    <x-ffast-progression-div :pourcentage="100" height="whatever" style="td"  text="VALIDE"/>
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
