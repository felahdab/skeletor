<div class='text-center mt-1 sticky-top' x-data='{ active : false }' style="top: 55px;">

    @switch ($mode)
    @case ('modificationmultiple')
        <button type="submit" 
                class="btn btn-primary" 
                name="validation"
                dusk="livret-multiple-enregistrer"
                x-on:click.prevent="active = true ;
                                    validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                                    validModal.show();
                                    opendivvalid=true">Enregistrer les validations</button>
        <a href="{{ route('transformation::transformation.indexparfonction') }}" class="btn btn-light">Retour</a>
        <button x-show="false" 
            x-on:uservalidated.window="if (active)
            { 
                active = false;  
                $wire.ValideElementsDuParcoursMultiple( selected_marins , date_validation , 
                                    commentaire, valideur, selected_compagnonnages , selected_taches , 
                                    selected_objectifs ,selected_sous_objectifs );
            }"></button>
        @break
    @case ('modification')
    @case ('modiflivret')
        <button type="submit" form="ssobjs" class="btn btn-primary" name="validation"
                x-on:click.prevent="active = true ;
                            validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                            validModal.show();
                            buttonid = 'validation' ;">
                Valider les éléments cochés</button>
        <button x-show="false" 
                x-on:uservalidated.window="if (active){ 
                    active = false; 
                    $wire.ValideElementsDuParcours( {{$user->id}} , date_validation , commentaire, 
                                            valideur, selected_compagnonnages , selected_taches , 
                                            selected_objectifs ,selected_sous_objectifs );}"></button>
        <button class="btn btn-danger" 
                name="annulation_validation"
                x-on:click="$wire.UnValideElementsDuParcours( {{$user->id}} , 
                                                            selected_compagnonnages , selected_taches , 
                                                            selected_objectifs ,selected_sous_objectifs );">
                Annuler la validation des éléments cochés</button>
        <a href="{{ route('transformation::transformation.livretpdf', $user->id) }}" class="btn btn-info"><x-bootstrap-icon iconname='printer.svg' /></a>
        @break
    @case ('proposition')
        <button type="submit" form="ssobjs" class="btn btn-primary" name="validation"
                x-on:click.prevent="active = true ;
                            validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                            validModal.show();
                            buttonid = 'validation' ;">
                Indiquer à mes tuteurs que je pense avoir validé les sous objectifs sélectionnés</button>
        <button x-show="false" 
                x-on:uservalidated.window="if (active){ 
                    active = false; 
                    $wire.ValideElementsDuParcours( {{$user->id}} , date_validation , commentaire, 
                                            valideur, selected_compagnonnages , selected_taches , 
                                            selected_objectifs ,selected_sous_objectifs );}"></button>
        <button class="btn btn-danger" 
                name="annulation_validation"
                x-on:click="$wire.UnValideElementsDuParcours( {{$user->id}} , 
                                                            selected_compagnonnages , selected_taches , 
                                                            selected_objectifs ,selected_sous_objectifs );">
                Retirer les sous objectifs sélectionnés de ma proposition de validation</button>
        <a href="{{ route('transformation::transformation.monlivretpdf', $user->id) }}" class="btn btn-info"><x-bootstrap-icon iconname='printer.svg' /></a>
        @break
    @endswitch
    <a href="#" style="text-decoration: none;">
        <img src='{!! asset("assets/images/fleche_haut.png") !!}' alt="haut page" width="40px">
    </a>
</div>