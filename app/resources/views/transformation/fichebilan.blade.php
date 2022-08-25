@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Fiche bilan de {{$user->prenom}} {{$user->name}}
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
                            <a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
                            <a href="{{ route('transformation.progression', $user->id) }}" class="btn btn-primary btn-sm">Progression</a>
        <div id='fiche' 
            style='width:100%; display:""; '>
            <table class='fiche-de-synthese mb-2 ' 
            id ='ficheDeSynthese ' 
            style='width: 100%; height: 95%; '>
                <thead style='border: 1px solid #C3C3C3; '>
                    <tr class='enTeteFicheSynthese'>
                        <td colspan='2'><h1>{{$user->displayString()}}</h1></td>
                        <td></td>
                        <td rowspan='4 '></td>
                    </tr>
                    <tr class='enTeteFicheSynthese '>
                        <td colspan='2 ' 
                        class='text-right'>Grade :</td>
                        <td>{{ $user->grade()->get()->first()->grade_libcourt }}</td>
                    </tr>

                    <tr class='enTeteFicheSynthese '>
                        <td colspan='2 ' 
                        class='text-right'>Sp&eacute;cialit&eacute; :</td>
                        <td>{{$user->specialite()->get()->first()->specialite_libcourt}}</td>
                    </tr>
                    <tr class='enTeteFicheSynthese '> <!-- Date d'embarquement -->
                        <td colspan='2' class='text-right'>Embarqué le :</td>
                        <td id='tdDateEmbarquement'>{{$user->date_embarq}}</td>
                    </tr>
                    <tr class='enTeteFicheSynthese'>
                        <!-- Pourcentage transformation -->
                        <td colspan='2' class='text-right'>Transformé à :</td>
                        <td id='tdTauxTransformation' class='text-left'>{{substr(100.0* $user->sous_objectifs()->get()->count() / $user->coll_sous_objectifs()->count(), 0, 4)}}%</td>
                    </tr>
                    <tr class='enTeteFicheSynthese'>
                        <!-- Fonction de service à quai -->
                        <td colspan='2' class='text-right'>Fonction de service à quai :</td>
                        <td id='tdFonctionServiceQuai' class='text-left'>{{$user->fonctions()->where('typefonction_id', 2)->get()->first()->fonction_libcourt}}</td>
                        <td id='tdFonctionServiceQuaiLache'>{{ $user->fonctions()->where('typefonction_id', 2)->get()->first()->date_lache ? 'LACHE' : 'NON LACHE'}}</td>
                    </tr>
                    <tr class='enTeteFicheSynthese'>
                        <!-- Fonction de quart à la mer -->
                        <td colspan='2' class='text-right'>Fonction de quart à la mer :</td>
                        <td id='tdFonctionQuartMer' class='text-left'>{{$user->fonctions()->where('typefonction_id', 1)->get()->first()->fonction_libcourt}}</td>
                        <td id='tdFonctionQuartMerLache'>{{ $user->fonctions()->where('typefonction_id', 1)->get()->first()->date_lache ? 'LACHE' : 'NON LACHE'}}</td>
                    </tr>
                    <tr>
                        <td colspan='4'>&nbsp;</td>
                    </tr>
                    <tr>
                        <!-- Entete fiche synthese -->
                        <th colspan='2' class='text-center'>COMPAGNONNAGE - PRODEF</th>
                        <th colspan='2' class='text-center'>STAGES - TP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->fonctions()->get() as $fonction)
                        @foreach($fonction->compagnonages()->get() as $comp)
                        <tr>
                            <td style='width:25%;'>{{$comp->comp_libcourt}}</td>
                            @php $pourcentage = $user->pourcentage_valides_pour_comp($comp);
                                $pourcentagestr = substr($pourcentage, 0,4);
                            @endphp
                            @if ($pourcentage == 100)
                                <td style='width:25%; background-color:green;'>{{$pourcentagestr}}%</td>
                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                <td style='width:25%; background-color:gold;'>{{$pourcentagestr}}%</td>
                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                <td style='width:25%; background-color:orange;'>{{$pourcentagestr}}%</td>
                            @else
                                <td style='width:25%; background-color:red;'>{{$pourcentagestr}}%</td>
                            @endif
                            <td style='width:25%;'></td>
                            <td style='width:25%; background-color:;'></td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection