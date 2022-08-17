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
        
        <div id='fiche' 
            style='width:100%; display:""; '>
            <table class='fiche-de-synthese mb-2 ' 
            id ='ficheDeSynthese ' 
            style='width: 100%; height: 95%; '>
                <thead style='border: 1px solid #C3C3C3; '>
                    <tr class='enTeteFicheSynthese'>
                        <td> <h1>&nbsp;&nbsp;{{$user->name . " " . $user->prenom}}</h1></td>
                        <td></td>
                        <td></td>
                        <td rowspan='4 '>&nbsp;
                            <img style='width: 70%;' 
                            src='../storage/photos/70.jpg' 
                            alt='photo '/>
                        </td>
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
                        <td id='tdTauxTransformation' class='text-left'>{{100.0* $user->sous_objectifs()->get()->count() / $user->coll_sous_objectifs()->count()}}%</td>
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
                            @php $pourcentage = $user->pourcentage_valides_pour_comp($comp) @endphp
                            @if ($pourcentage == 100)
                                <td style='width:25%; background-color:green;'>{{$pourcentage}}%</td>
                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                <td style='width:25%; background-color:gold;'>{{$pourcentage}}%</td>
                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                <td style='width:25%; background-color:orange;'>{{$pourcentage}}%</td>
                            @else
                                <td style='width:25%; background-color:red;'>{{$pourcentage}}%</td>
                            @endif
                            <td style='width:25%;'></td>
                            <td style='width:25%; background-color:;'></td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        
        
        <div id='progression' style='width:100%;display:none'>
            <div>
                <div style='display: flex; padding: 2%; background-color: transparent; justify-content: space-evenly;'>
                    <div style=' width: 48%; background-color: transparent; position: relative; '>
                        <div class='flex' style='background-color: transparent; justify-content: center;'>
                            <h1>Taux de transformation global</h1>
                        </div>
                        <div class='flex'><canvas id='global_canvas' style='width:100%;'></canvas></div>
                        <script>
                            var ctx = document.getElementById('global_canvas');
                            var chart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: {!! '["'. implode('","', array_keys($user->historique_validation_sous_objectifs_cumulatif())) .'"]' !!},
                                    datasets: [{
                                        label: ' Nb sous-objectifs réalisés',
                                        backgroundColor: 'rgba(50,108,172,0.4)',
                                        borderColor: 'rgb(242,223,205)',
                                        data: {{ "[". implode(",", array_values($user->historique_validation_sous_objectifs_cumulatif())) ."]"}}
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                max: {{ $user->nbSousObjectifsAValider() }},
                                            }
                                        }]
                                    },
                                }
                            });
                        </script>
                        <div style='position: absolute; width: 100%; height: 35px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </div>
                        @php $pourcentage = 100.0* $user->sous_objectifs()->get()->count() / $user->coll_sous_objectifs()->count(); @endphp
                        <div style='position: absolute; width: {{$pourcentage}}%; height: 35px; background-color: red; margin-top: 1%; border: 1px solid black;'>
                            <h3>{{$pourcentage}}%</h3>
                        </div>
                    </div>
                    <div style='display: flex; width: 48%; background-color: transparent; margin-top: 2%;'>
                        <div class='card border-primary mb-3' style='width:50%;'>
                            <div class='card-header text-primary'>Stages</div>
                            <div class='card-body '></div>
                        </div>
                        <div class='card border-primary mb-3' style='width:50%;padding-bottom: 20px;'>
                            <div class='card-header text-primary'>Compagnonnages</div>
                            <div class='card-body'>
                            @foreach($user->fonctions()->get() as $fonction)
                                @foreach($fonction->compagnonages()->get() as $compagnonage)
                                <p class='card-text' style='margin-bottom: 25px;'>
                                    <span style='width:25%;'>{{$compagnonage->comp_libcourt}}</span>
                                    <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                                        <span style='display:flex; width: 100%; position: relative; '>
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </span>
                                            @php $pourcentage = $user->pourcentage_valides_pour_comp($compagnonage) @endphp
                                            @if ($pourcentage == 100)
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: green; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: gold; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: orange; margin-top: 1%; border: 1px solid black;'></span>
                                            @else
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: red; margin-top: 1%; border: 1px solid black;'></span>
                                            @endif
                                            <span style='position: absolute; margin-left: 5px;'><b>{{$pourcentage}}%</b></span>
                                        </span>
                                    </span>
                                </p>
                                @endforeach
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($user->fonctions()->get() as $fonction)
            <div>
                <div style='display: flex; padding: 2%; background-color: transparent; justify-content: space-evenly;'>
                    <div style=' width: 48%; background-color: transparent; position: relative; '>
                        <div class='flex' style='background-color: transparent; justify-content: center;'>
                            <h1>{{$fonction->fonction_libcourt}}</h1>
                        </div>
                        <div class='flex'>
                        <canvas id='fonc{{$fonction->id}}' 
                        style='width:100%; display:{{ $fonction->coll_sous_objectifs()->count()==0 ? "none" : ""}}'></canvas></div>
                        <script>
                            var ctx = document.getElementById('fonc{!!$fonction->id!!}');
                            var chart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: {!! '["'. implode('","', array_keys($user->historique_validation_sous_objectifs_cumulatif($fonction))) .'"]' !!},
                                    datasets: [{
                                        label: ' Nb sous-objectifs réalisés',
                                        backgroundColor: 'rgba(50,108,172,0.4)',
                                        borderColor: 'rgb(242,223,205)',
                                        data: {{ "[". implode(",", array_values($user->historique_validation_sous_objectifs_cumulatif())) ."]"}}
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                max: {{ $fonction->coll_sous_objectifs()->count() }},
                                            }
                                        }]
                                    },
                                }
                            });
                        </script>
                            <div style='position: absolute; width: 100%; height: 35px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </div>
                            @if ($fonction->coll_sous_objectifs()->count()!=0 ) 
                            @php $pourcentage = $user->pourcentage_valides_pour_fonction($fonction) @endphp
                            @if ($pourcentage == 100)
                                <div style='position: absolute; width: {{$pourcentage}}%; height: 35px; background-color: green; margin-top: 1%; border: 1px solid black;'></div>
                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                <div style='position: absolute; width: {{$pourcentage}}%; height: 35px; background-color: gold; margin-top: 1%; border: 1px solid black;'></div>
                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                <div style='position: absolute; width: {{$pourcentage}}%; height: 35px; background-color: orange; margin-top: 1%; border: 1px solid black;'></div>
                            @else
                                <div style='position: absolute; width: {{$pourcentage}}%; height: 35px; background-color: red; margin-top: 1%; border: 1px solid black;'></div>
                            @endif
                                <h3>{{$pourcentage}}%</h3>
                            @endif
                    </div>
                    <div style='display: flex; width: 48%; background-color: transparent; margin-top: 2%;'>
                        <div class='card border-primary mb-3' style='width:50%;'>
                            <div class='card-header text-primary'>Stages</div>
                            <div class='card-body '>
                            @foreach($fonction->stages()->get() as $stage)
                                <p class='card-text' style='margin-bottom: 25px;'>
                                    <span style='width:25%;'>{{$stage->stage_libcourt}}</span>
                                    <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                                        <span style='display:flex; width: 100%; position: relative; '>
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </span>
                                            @if ($user->stages()->get()->find($stage))
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: green; margin-top: 1%; border: 1px solid black;'></span>
                                            <span style='position: absolute; margin-left: 5px;'><b>100%</b></span>
                                            @else
                                            <span style='position: absolute; width: 0%; height: 20px; background-color: red; margin-top: 1%; border: 1px solid black;'></span>
                                            <span style='position: absolute; margin-left: 5px;'><b>0%</b></span>
                                            @endif
                                        </span>
                                    </span>
                                </p>
                                @endforeach
                            </div>
                        </div>
                        <div class='card border-primary mb-3' style='width:50%;padding-bottom: 20px;'>
                            <div class='card-header text-primary'>Compagnonnages</div>
                            <div class='card-body'>
                                @foreach($fonction->compagnonages()->get() as $compagnonage)
                                <p class='card-text' style='margin-bottom: 25px;'>
                                    <span style='width:25%;'>{{$compagnonage->comp_libcourt}}</span>
                                    <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                                        <span style='display:flex; width: 100%; position: relative; '>
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </span>
                                            @php $pourcentage = $user->pourcentage_valides_pour_comp($compagnonage) @endphp
                                            @if ($pourcentage == 100)
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: green; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: gold; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: orange; margin-top: 1%; border: 1px solid black;'></span>
                                            @else
                                                <span style='position: absolute; width: {{$pourcentage}}%; height: 20px; background-color: red; margin-top: 1%; border: 1px solid black;'></span>
                                            @endif
                                            <span style='position: absolute; margin-left: 5px;'><b>{{$pourcentage}}%</b></span>
                                        </span>
                                    </span>
                                </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    
@endsection