<div style='width:100%; display:""; '
    wire:init="triggerLoad">

    <table class=' mb-2 ' id ='ficheDeSynthese '  style='width: 100%; height: 95%; '>
        <thead style='border: 1px solid #C3C3C3; font-weight: bold; font-size: large;'>
            <tr>
                <td colspan='2'><h1>{{$user->display_name}}</h1></td>
                <td></td>
                <td rowspan='4 '>@if($readyToLoad)<img src="{{ $user->getAnnudefPictureUrl() }}" width="150px">@endif</td>
            </tr>

            <tr>
                <td colspan='2 '>Sp&eacute;cialit&eacute; :</td>
                <td>{{$user->displaySpecialite()}}</td>
            </tr>
            <tr>
                <td colspan='2'>Date d'embarquement :</td>
                <td>{{$user->date_embarq}}</td>
            </tr>
            <tr>
                <td colspan='2'>Taux de transformation :</td>
                <td>{{round($user->taux_de_transformation, 2)}}%</td>
            </tr>
            @if ($user->displayDestination())
            <tr>
                <td colspan='2'>Unité destination :</td>
                <td>{{$user->displayDestination()}}</td>
                <td></td>
                <td></td>
            </tr>
            @endif
            <tr>
                <td colspan='2'>Secteur :</td>
                <td>{{$user->displaySecteur()}}</td>
                <td></td>
                <td></td>
            </tr>
            @if($readyToLoad)
                @if ($user->getTransformationManager()->fonctionAQuai() != null)
                    @foreach($user->getTransformationManager()->fonctionAQuai() as $fonctionAquai)
                        <tr>
                            <td colspan='2'>Fonction de service à quai :</td>
                            <td>{{$fonctionAquai->fonction_libcourt}}</td>
                            <td>{{ $fonctionAquai->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</td>
                        </tr>
                    @endforeach
                @endif
                @if ($user->getTransformationManager()->fonctionAMer() != null)
                    @foreach($user->getTransformationManager()->fonctionAMer() as $fonctionAmer)
                        <tr>
                            <td colspan='2'>Fonction de service à la mer :</td>
                            <td>{{$fonctionAmer->fonction_libcourt}}</td>
                            <td>{{ $fonctionAmer->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</td>
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
