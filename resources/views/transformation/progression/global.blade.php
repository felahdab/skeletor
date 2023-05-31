<div>
    <div style='display: flex; padding: 2%; background-color: transparent; justify-content: space-evenly;'>
        <div style=' width: 48%; background-color: transparent; position: relative; '>
            <div class='flex' style='background-color: transparent; justify-content: center;'>
                <h1>Taux de transformation global</h1>
            </div>
            <div class='flex'><canvas id='global_canvas' style='width:100%;'></canvas></div>
            <script>
            @php
                $historique = $user->getTransformationManager()->historique_validation_sous_objectifs_cumulatif();
            @endphp
            
                var ctx = document.getElementById('global_canvas');
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
                                suggestedMax: {{$user->getTransformationManager()->sous_objectifs_du_parcours()->count() }}
                                }
                            }
                        }
                    }
                );
            </script>
            

            <x-ffast-progression-div :pourcentage="$user->taux_de_transformation" height="35px" style="div"/>
        </div>
        <div style='display: flex; width: 48%; background-color: transparent; margin-top: 2%;'>
            <div class='card border-primary mb-3' style='width:50%;'>
                <div class='card-header text-primary'>Stages</div>
                <div class='card-body '>
                    @foreach($user->getTransformationManager()->stages as $stage)
                     <p class='card-text' style='margin-bottom: 25px;'>
                        <span style='width:25%;'>{{ $stage->stage_libcourt }}</span>
                        <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                        @if ($user->getTransformationManager()->aValideLeStage($stage))
                            <x-ffast-progression-div :pourcentage="100" height="20px" style="span"/>
                        @else
                            <x-ffast-progression-div :pourcentage="0" height="20px" style="span"/>
                        @endif
                        </span>
                    </p>
                    @endforeach
                </div>
            </div>
            <div class='card border-primary mb-3' style='width:50%;padding-bottom: 20px;'>
                <div class='card-header text-primary'>Compagnonnages</div>
                <div class='card-body'>
                @foreach($user->getTransformationManager()->compagnonages_du_parcours() as $compagnonage)
                    <p class='card-text' style='margin-bottom: 25px;'>
                        <span style='width:25%;'>{{ $compagnonage->comp_libcourt }}</span>
                        <span style='width:25%; background-color: transparent; margin-top: 5px;'>
                            <x-ffast-progression-div :pourcentage="$user->getTransformationManager()->taux_de_transformation(null, $compagnonage)" height="20px"  style="span"/>
                        </span>
                    </p>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
