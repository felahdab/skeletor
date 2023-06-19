<table class='table table-bordered'>
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
            {{ htmlspecialchars_decode($fonction->pivot->valideur_double) }}
        @endif
        @if ($mode == "modification" || $mode == "proposition")
            @if ( $user->getTransformationManager()->aProposeDoubleFonction($fonction) ||  $user->getTransformationManager()->aValideDoubleFonction($fonction) )
                <button class="btn btn-danger" 
                x-on:click.prevent="$wire.UnValideDoubleFonction( {{ $user->id }}, {{ $fonction->id }} );">
                Annuler</button>
            @endif
            @if ( $mode=="modification" && ! $user->getTransformationManager()->aValideDoubleFonction($fonction) )
                <button type="submit" 
                    class="btn btn-primary" 
                    name="validation_double"
                    x-on:click.prevent="active  = true; 
                                buttonid ='validation_double'; 
                                validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                        validModal.show();">Valider</button>
                <button x-show="false" 
                    x-on:uservalidated.window="if (active)
                    {   
                        active = false;  
                        $wire.ValideDoubleFonction( {{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                    };"></button>
            @endif
            @if ( $mode=="proposition"  && ! $user->getTransformationManager()->aProposeDoubleFonction($fonction) && !$user->getTransformationManager()->aValideDoubleFonction($fonction))
                <button type="submit" 
                    class="btn btn-primary" 
                    name="validation_double"
                    x-on:click.prevent="active  = true; 
                                buttonid ='validation_double'; 
                                validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                        validModal.show();">Proposer la validation</button>
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
            {{ htmlspecialchars_decode($fonction->pivot->valideur_lache) }}
        @endif

        @if ($mode =="modification" || $mode=="proposition")
            @if ( $user->getTransformationManager()->aProposeLacheFonction($fonction) || $user->getTransformationManager()->aValideLacheFonction($fonction) )
                <button class="btn btn-danger" 
                x-on:click.prevent="$wire.UnValideLacheFonction( {{ $user->id }}, {{ $fonction->id }} );">
                Annuler</button>
            @endif
            @if ( $mode =="modification" && ! $user->getTransformationManager()->aValideLacheFonction($fonction) )
                <button type="submit" 
                    class="btn btn-primary" 
                    name="validation_lache"
                    x-on:click.prevent="active  = true; 
                                buttonid ='validation_lache'; 
                                validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                        validModal.show();">Valider</button>
                <button x-show="false" 
                    x-on:uservalidated.window="if (active)
                    {   
                        active = false;  
                        $wire.ValideLacheFonction( {{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                    };"></button>
            @endif
            
            @if ($mode =="proposition" && ! $user->getTransformationManager()->aValideLacheFonction($fonction) && ! $user->getTransformationManager()->aProposeLacheFonction($fonction) )
                <button type="submit" 
                    class="btn btn-primary" 
                    name="validation_lache"
                    x-on:click.prevent="active  = true; 
                                buttonid ='validation_lache'; 
                                validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                        validModal.show();">Proposer la validation</button>
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
