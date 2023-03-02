<table class='table'>
    <!--tr class='lignecomp div-table-contrat-compagnonnage'>
        <th colspan='5'>{{$fonction->fonction_liblong }}</th>
    </tr-->
    <tr  class="table-active text-center">
            <th style='width:5%;'>&nbsp;</td>
            <th style='width:70%;'>Commentaire</td>
            <th style='width:10%;'>Date de Visa</td>
            <th style='width:10%;'>Viseur</td>
            <th style='width:5%;'>Lieu de formation</td>
    </tr>
    @if ($fonction->fonction_double)
    <tr x-data='{ active : false }'>
        <td>DOUBLE</td>
        <td class="text-start">
        @if ($user->aProposeDoubleFonction($fonction) || $user->aValideDoubleFonction($fonction))
            {{ $fonction->pivot->commentaire_double }}
        @endif
        </td>
        <td>
        @if ($user->aValideDoubleFonction($fonction))
            <button class='btn btn-success' type='button' disabled>
                VALIDE {{ $fonction->pivot->date_double }}
            </button>
        @endif
        @if ($user->aProposeDoubleFonction($fonction))
            <button class='btn btn-primary' type='button' disabled>
                PROPOSE {{ $fonction->pivot->date_proposition_double }}
            </button>
        @endif
        </td>
        <td>
        @if ( $user->aProposeDoubleFonction($fonction) || $user->aValideDoubleFonction($fonction) )
            {{ $fonction->pivot->valideur_double }}
            <button class="btn btn-danger" 
            x-on:click.prevent="$wire.UnValideDoubleFonction( {{ $user->id }}, {{ $fonction->id }} );">
            Annuler</button>
        @endif
        @if ( $readwrite && ! $user->aValideDoubleFonction($fonction) )
            <button type="submit" 
                class="btn btn-primary" 
                name="validation_double"
                x-on:click.prevent="active  = true; 
                               buttonid ='validation_double'; 
                               opendivvalid =true;">Valider</button>
              <button x-show="false" 
                x-on:uservalidated.window="if (active)
                {   
                    active = false;  
                    $wire.ValideDoubleFonction( {{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                 };"></button>
        @endif
        @if ( ! $readwrite && ! $user->aProposeDoubleFonction($fonction) )
            <button type="submit" 
                class="btn btn-primary" 
                name="validation_double"
                x-on:click.prevent="active  = true; 
                               buttonid ='validation_double'; 
                               opendivvalid =true;">Proposer la validation</button>
              <button x-show="false" 
                x-on:uservalidated.window="if (active)
                {   
                    active = false;  
                    $wire.ValideDoubleFonction( {{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                 };"></button>
        @endif
        </td>
        <td>Bord</td>
    </tr>
    @endif
    @if ($fonction->fonction_lache)
    <tr x-data='{ active : false }'>
        <td>LACHER</td>
        <td class="text-start">
        @if ($fonction->pivot->date_double != null)
            {{ $fonction->pivot->commentaire_lache }}
        @endif
        </td>
        <td>
        @if ($fonction->pivot->date_lache != null)
            <button class='btn btn-success' type='button' disabled>
                VALIDE {{ $fonction->pivot->date_lache }}
            </button>
        @endif
        </td>
        <td>
        @if ($fonction->pivot->valideur_lache != null and $readwrite)
            {{ $fonction->pivot->valideur_lache }}
            <button class="btn btn-danger" 
            x-on:click.prevent="$wire.UnValideLacheFonction( {{ $user->id }}, {{ $fonction->id }} );">
            Annuler</button>
        @elseif($readwrite)
        <button type="submit" 
            class="btn btn-primary" 
            name="validation_lache"
            x-on:click.prevent="active  = true; 
                               buttonid ='validation_lache'; 
                           opendivvalid =true;">Valider</button>
            <button x-show="false"  
                    x-on:uservalidated.window="if (active)
                    { 
                        active = false;  
                        $wire.ValideLacheFonction({{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                    }"></button>
        @endif
        </td>
        <td>Bord</td>
    </tr>
    @endif
</table>