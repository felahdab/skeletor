<div class='text-center mt-1 sticky-top' style="top:3.5rem" x-data='{ active : false }'>
    @if($mode=='unique')
        
    
    <button type="submit" 
    form="ssobjs"
    class="btn btn-primary" 
    name="validation"
    x-on:click.prevent="active = true ;
                        opendivvalid = true ;
                        buttonid = 'validation' ;">Valider les éléments cochés</button>
    <button x-show="false" 
            x-on:uservalidated.window="if (active)
            { 
                active = false;  
$wire.ValideElementsDuParcours( {{$user->id}} , date_validation , commentaire, valideur, selected_compagnonnages , selected_taches , selected_objectifs ,selected_sous_objectifs );
            }"></button>
    <button class="btn btn-danger" 
    name="annulation_validation"
    x-on:click="
$wire.UnValideElementsDuParcours( {{$user->id}} , selected_compagnonnages , selected_taches , selected_objectifs ,selected_sous_objectifs );">Annuler la validation des éléments cochés</button>
    <a href="{{ route('transformation.livretpdf', $user->id) }}" class="btn btn-info">Imprimer</a>
    
    
    @elseif($mode=='multiple')
    
    <button type="submit" 
    class="btn btn-primary" 
    name="validation"
    x-on:click.prevent='active = true ;;
                        opendivvalid=true'>Enregistrer les validations</button>
    <a href="{{ url()->previous() }}" class="btn btn-light">Retour</a>
    <button x-show="false" 
        x-on:uservalidated.window="if (active)
        { 
            active = false;  
$wire.ValideElementsDuParcoursMultiple( selected_marins , date_validation , commentaire, valideur, selected_compagnonnages , selected_taches , selected_objectifs ,selected_sous_objectifs );
        }"></button>
        
    @endif
</div><!-- fin de la div avec boutons speciaux -->