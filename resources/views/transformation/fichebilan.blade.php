@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="transformation"/>
@endsection


@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Fiche bilan de {{$user->display_name}}
        </div>
        
        @if($readwrite)
            <a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
            <a href="{{ route('transformation.progression', $user->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation.fichebilan', $user->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            @can('users.stages')
                <a href="{{ route('users.stages', $user->id) }}" class="btn btn-danger btn-sm">Stages</a>
            @endcan
            <a href="{{ url()->previous() }}" class="btn btn-default btn-sm">Annuler</a>
        @else
            <a href="{{ route('transformation.monlivret') }}" class="btn btn-warning btn-sm">Mon livret de transformation</a>
            <a href="{{ route('transformation.maprogression') }}" class="btn btn-primary btn-sm">Ma progression</a>
            <a href="{{ route('transformation.mafichebilan') }}" class="btn btn-secondary btn-sm">Ma fiche bilan</a>
        @endif
        
        <div id='fiche' 
            style='width:100%; display:""; '>
            <table class='fiche-de-synthese mb-2 ' 
            id ='ficheDeSynthese ' 
            style='width: 100%; height: 95%; '>
                <thead style='border: 1px solid #C3C3C3; '>
                    <tr class='enTeteFicheSynthese'>
                        <td colspan='2'><h1>{{$user->display_name}}</h1></td>
                        <td></td>
                        <td rowspan='4 '><img src="{{url(asset('public/' . $user->photo))}}" </td>
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
                    @if ($user->fonctionAQuai() != null)
                    <tr class='enTeteFicheSynthese'>
                        <!-- Fonction de service à quai -->
                        <td colspan='2' class='text-right'>Fonction de service à quai :</td>
                        <!------------------------------------------------->
                        <!-- un user n'a pas forcement de fonction a quai-->
                        <!------------------------------------------------->
                        <td id='tdFonctionServiceQuai' class='text-left'>{{$user->fonctionAQuai()->fonction_libcourt}}</td>
                        <td id='tdFonctionServiceQuaiLache'>{{ $user->fonctionAQuai()->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</td>
                    </tr>
                    @endif
                    @if ($user->fonctionAMer() != null)
                    <tr class='enTeteFicheSynthese'>
                        <!-- Fonction de quart à la mer -->
                        <td colspan='2' class='text-right'>Fonction de quart à la mer :</td>
                        <!--------------------------------------------------->
                        <!-- un user n'a pas forcement de fonction a la mer-->
                        <!--------------------------------------------------->
                        <td id='tdFonctionQuartMer' class='text-left'>{{$user->fonctionAMer()->fonction_libcourt}}</td>
                        <td id='tdFonctionQuartMerLache'>{{ $user->fonctionAMer()->pivot->date_lache ? 'LACHE' : 'NON LACHE'}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan='4'>&nbsp;</td>
                    </tr>
                    <tr>
                        <!-- Entete fiche synthese -->
                        <th colspan='2' class='text-center'>COMPAGNONNAGES</th>
                        <th colspan='2' class='text-center'>STAGES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listcomp as $comp)
                        <tr>
                            @if ($comp == null)
                                <td style='width:25%;'></td>
                                <td style='width:25%;'></td>
                            @else
                                <td style='width:25%;'>{{$comp->comp_libcourt}}</td>
                                
                                @php 
                                    $pourcentage = $user->pourcentage_valides_pour_comp($comp);
                                @endphp
                                <x-ffast-progression-div :pourcentage="$pourcentage" height="whatever" style="td"/>
                            @endif
                            
                            @php $stage = $liststage[$loop->index] ; @endphp
                            @if ($stage == null)
                                <td style='width:25%;'></td>
                                <td style='width:25%;'></td>
                            @else
                                <td style='width:25%;'>{{$stage->stage_libcourt}}</td>
                                @if ($user->aValideLeStage($stage))
                                    <x-ffast-progression-div :pourcentage="100" height="whatever" style="td"  text="VALIDE"/>
                                @else
                                    <x-ffast-progression-div :pourcentage="0" height="whatever" style="td" text="NON VALIDE"/>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection