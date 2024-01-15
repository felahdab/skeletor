<div>
    <div style='display: flex; padding: 2%; background-color: transparent; justify-content: space-evenly;'>
        <div style=' width: 48%; background-color: transparent; position: relative; '>
            <div class='flex' style='background-color: transparent; justify-content: center;'>
                <h1>{{$fonction->fonction_libcourt}}</h1>
            </div>
            <div class='flex'>
            @php
                $collssobj = $user->getTransformationManager()->sous_objectifs_du_parcours($fonction);
                $collssobjcount = $collssobj->count();
            @endphp
            <canvas id='fonc{{$fonction->id}}' 
            style='width:100%; display:{{ $collssobjcount == 0 ? "none" : ""}}'></canvas></div>
            <script>
                @php
                    $historique = $user->getTransformationManager()->historique_validation_sous_objectifs_cumulatif($fonction);
                @endphp
                var ctx = document.getElementById('fonc{!!$fonction->id!!}');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! '["'. implode('","', array_keys( $historique )) .'"]' !!},
                        datasets: [{
                            label: ' Nb sous-objectifs réalisés',
                            backgroundColor: 'rgba(50,108,172,0.4)',
                            borderColor: 'rgb(242,223,205)',
                            data: {{ "[". implode(",", array_values( $historique )) ."]"}}
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                suggestedMax: {{ $collssobjcount }}
                                }
                            }
                        }
                    }
                );
            </script>
                <x-transformation::ffast-progression-div :pourcentage="$fonction->pivot->taux_de_transformation" height="35px"/>
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
                                @if ($user->getTransformationManager()->aValideLeStage($stage))
                                    <x-transformation::ffast-progression-div :pourcentage="100" height="20px" style="span"/>
                                @else
                                    <x-transformation::ffast-progression-div :pourcentage="0" height="20px" style="span"/>
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
                            <x-transformation::ffast-progression-div :pourcentage="$user->getTransformationManager()->taux_de_transformation(null, $compagnonage)" height="20px" style="span"/>
                        </span>
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
