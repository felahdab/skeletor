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
            @php
            //ddd($fonction)
            @endphp
        @if ($user->getTransformationManager()->aProposeDoubleFonction($fonction) || $user->getTransformationManager()->aValideDoubleFonction($fonction))
            {{ $fonction->pivot->commentaire_double }}
        @endif
        </td>
        <td>
        @if ($user->getTransformationManager()->aValideDoubleFonction($fonction))
            <button class='btn btn-success' type='button' disabled>
                VALIDE {{ $fonction->pivot->date_double }}
            </button>
        @endif
        @if ($user->getTransformationManager()->aProposeDoubleFonction($fonction))
            <button class='btn btn-primary' type='button' disabled>
                PROPOSE {{ $fonction->pivot->date_proposition_double }}
            </button>
        @endif
        </td>
        <td>
        @if ( $user->getTransformationManager()->aProposeDoubleFonction($fonction) ||  $user->getTransformationManager()->aValideDoubleFonction($fonction) )
            {{ $fonction->pivot->valideur_double }}
        @endif
        @if (count(auth()->user()->roles()->where('name','visiteur')->get())==0)
            @if ( $user->getTransformationManager()->aProposeDoubleFonction($fonction) || ($readwrite && $user->getTransformationManager()->aValideDoubleFonction($fonction) ) )
                <button class="btn btn-danger" 
                x-on:click.prevent="$wire.UnValideDoubleFonction( {{ $user->id }}, {{ $fonction->id }} );">
                Annuler</button>
            @endif
            @if ( $readwrite && ! $user->getTransformationManager()->aValideDoubleFonction($fonction) )
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
            @if ( ! $readwrite && ! $user->getTransformationManager()->aProposeDoubleFonction($fonction) && !$user->getTransformationManager()->aValideDoubleFonction($fonction))
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
        @endif
        </td>
        <td>Bord</td>
    </tr>
    @endif
    @if ($fonction->fonction_lache)
    <tr x-data='{ active : false }'>
        <td>LACHER</td>
        <td class="text-start">
        @if ($user->getTransformationManager()->aProposeLacheFonction($fonction) || $user->getTransformationManager()->aValideLacheFonction($fonction))
            {{ $fonction->pivot->commentaire_lache }}
        @endif
        </td>
        <td>
        @if ($user->getTransformationManager()->aValideLacheFonction($fonction))
            <button class='btn btn-success' type='button' disabled>
                VALIDE {{ $fonction->pivot->date_lache }}
            </button>
        @endif
        @if ($user->getTransformationManager()->aProposeLacheFonction($fonction))
            <button class='btn btn-primary' type='button' disabled>
                PROPOSE {{ $fonction->pivot->date_proposition_lache}}
            </button>
        @endif
        </td>
        <td>
        @if ( $user->getTransformationManager()->aProposeLacheFonction($fonction) || $user->getTransformationManager()->aValideLacheFonction($fonction) )
            {{ $fonction->pivot->valideur_lache }}
        @endif
        @if (count(auth()->user()->roles()->where('name','visiteur')->get())==0)
            @if ( $user->getTransformationManager()->aProposeLacheFonction($fonction) || ($readwrite && $user->getTransformationManager()->aValideLacheFonction($fonction) ) )
                <button class="btn btn-danger" 
                x-on:click.prevent="$wire.UnValideLacheFonction( {{ $user->id }}, {{ $fonction->id }} );">
                Annuler</button>
            @endif
            @if ( $readwrite && ! $user->getTransformationManager()->aValideLacheFonction($fonction) )
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
                        $wire.ValideLacheFonction( {{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                    };"></button>
            @endif
            @if ( ! $readwrite && ! $user->getTransformationManager()->aValideLacheFonction($fonction) && ! $user->getTransformationManager()->aProposeLacheFonction($fonction) )
                <button type="submit" 
                    class="btn btn-primary" 
                    name="validation_lache"
                    x-on:click.prevent="active  = true; 
                                buttonid ='validation_lache'; 
                                opendivvalid =true;">Proposer la validation</button>
                <button x-show="false" 
                    x-on:uservalidated.window="if (active)
                    {   
                        active = false;  
                        $wire.ValideLacheFonction( {{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                    };"></button>
            @endif
        @endif
        </td>
        <td>Bord</td>
    </tr>
    @endif
</table>