@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Suivi de la progression de {{$user->prenom}} {{$user->name}}
        </div>
        @if($readwrite)
            <a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
            <a href="{{ route('transformation.progression', $user->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation.fichebilan', $user->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            @can('stages.consulter')
                <a href="{{ route('users.stages', $user->id) }}" class="btn btn-danger btn-sm">Stages</a>
            @endcan
            <a href="{{ route('transformation.index') }}" class="btn btn-default btn-sm">Annuler</a>
        @else
             <a href="{{ route('transformation.monlivret') }}" class="btn btn-warning btn-sm">Mon livret de transformation</a>
            <a href="{{ route('transformation.maprogression') }}" class="btn btn-primary btn-sm">Ma progression</a>
            <a href="{{ route('transformation.mafichebilan') }}" class="btn btn-secondary btn-sm">Ma fiche bilan</a>
        @endif
        @if ($user->en_transformation)
        <div id='progression' style='width:100%;'>
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
                            @php $pourcentage = $user->taux_de_transformation;
                                     $pourcentagestr = substr($pourcentage, 0, 5);
                            @endphp
                            @if ($pourcentage == 100)
                                <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: green; margin-top: 1%; border: 1px solid black;'>
                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: gold; margin-top: 1%; border: 1px solid black;'>
                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: orange; margin-top: 1%; border: 1px solid black;'>
                            @else
                                <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: red; margin-top: 1%; border: 1px solid black;'>
                            @endif
                            <h3>{{$pourcentage}}%</h3>
                        </div>
                    </div>
                    <div style='display: flex; width: 48%; background-color: transparent; margin-top: 2%;'>
                        <div class='card border-primary mb-3' style='width:50%;'>
                            <div class='card-header text-primary'>Stages</div>
                            <div class='card-body '>
                                @foreach($user->stages()->get() as $stage)
                                    <p class='card-text' style='margin-bottom: 25px;'>
                                        <span style='width:25%;'>{{$stage->stage_libcourt}}</span>
                                        <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                                            <span style='display:flex; width: 100%; position: relative; '>
                                                <span style='position: absolute; width: 100%; height: 20px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </span>
                                                @if ($user->aValideLeStage($stage))
                                                    <span style='position: absolute; width: 100%; height: 20px; background-color: green; margin-top: 1%; border: 1px solid black;'></span>
                                                    <span style='position: absolute; margin-left: 5px;'><b>100%</b></span>
                                                @else
                                                    <span style='position: absolute; width: 100%; height: 20px; background-color: red; margin-top: 1%; border: 1px solid black;'></span>
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
                            @foreach($user->fonctions()->with('compagnonages')->get() as $fonction)
                                @foreach($fonction->compagnonages as $compagnonage)
                                <p class='card-text' style='margin-bottom: 25px;'>
                                    <span style='width:25%;'>{{ $compagnonage->comp_libcourt }}</span>
                                    <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                                        <span style='display:flex; width: 100%; position: relative; '>
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </span>
                                            @php $pourcentage = $user->pourcentage_valides_pour_comp($compagnonage);
                                                 $pourcentagestr = substr($pourcentage, 0, 5);
                                            @endphp
                                            @if ($pourcentage == 100)
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: green; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: gold; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: orange; margin-top: 1%; border: 1px solid black;'></span>
                                            @else
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: red; margin-top: 1%; border: 1px solid black;'></span>
                                            @endif
                                            <span style='position: absolute; margin-left: 5px;'><b>{{$pourcentagestr}}%</b></span>
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
            @foreach($user->fonctions()->with('stages')->with('compagnonages')->get() as $fonction)
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
                                        data: {{ "[". implode(",", array_values($user->historique_validation_sous_objectifs_cumulatif($fonction))) ."]"}}
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
                                @php $pourcentage = $fonction->pivot->taux_de_transformation;
                                     $pourcentagestr = substr($pourcentage, 0, 5);
                                @endphp
                                @if ($pourcentage == 100)
                                    <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: green; margin-top: 1%; border: 1px solid black;'>
                                @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                    <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: gold; margin-top: 1%; border: 1px solid black;'>
                                @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                    <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: orange; margin-top: 1%; border: 1px solid black;'>
                                @else
                                    <div style='position: absolute; width: {{$pourcentagestr}}%; height: 35px; background-color: red; margin-top: 1%; border: 1px solid black;'>
                                @endif
                                <h3>{{$pourcentagestr}}%</h3></div>
                            @endif
                    </div>
                    <div style='display: flex; width: 48%; background-color: transparent; margin-top: 2%;'>
                        <div class='card border-primary mb-3' style='width:50%;'>
                            <div class='card-header text-primary'>Stages</div>
                            <div class='card-body '>
                            @foreach($fonction->stages as $stage)
                                <p class='card-text' style='margin-bottom: 25px;'>
                                    <span style='width:25%;'>{{$stage->stage_libcourt}}</span>
                                    <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                                        <span style='display:flex; width: 100%; position: relative; '>
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </span>
                                            @if ($user->aValideLeStage($stage))
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: green; margin-top: 1%; border: 1px solid black;'></span>
                                            <span style='position: absolute; margin-left: 5px;'><b>100%</b></span>
                                            @else
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: red; margin-top: 1%; border: 1px solid black;'></span>
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
                                @foreach($fonction->compagnonages as $compagnonage)
                                <p class='card-text' style='margin-bottom: 25px;'>
                                    <span style='width:25%;'>{{$compagnonage->comp_libcourt}}</span>
                                    <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                                        <span style='display:flex; width: 100%; position: relative; '>
                                            <span style='position: absolute; width: 100%; height: 20px; background-color: transparent; margin-top: 1%; border: 1px solid black;'> </span>
                                            @php $pourcentage = $user->pourcentage_valides_pour_comp($compagnonage);
                                                 $pourcentagestr = substr($pourcentage, 0, 4);
                                            @endphp
                                            @if ($pourcentage == 100)
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: green; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 70 and $pourcentage < 100)
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: gold; margin-top: 1%; border: 1px solid black;'></span>
                                            @elseif ($pourcentage >= 30 and $pourcentage < 70)
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: orange; margin-top: 1%; border: 1px solid black;'></span>
                                            @else
                                                <span style='position: absolute; width: {{$pourcentagestr}}%; height: 20px; background-color: red; margin-top: 1%; border: 1px solid black;'></span>
                                            @endif
                                            <span style='position: absolute; margin-left: 5px;'><b>{{$pourcentagestr}}%</b></span>
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
        @endif
    
@endsection