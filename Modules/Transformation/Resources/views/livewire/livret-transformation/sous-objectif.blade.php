<td>
    @if($sous_objectif->ssobj_lienurl != NULL)
        <a href="{{$sous_objectif->ssobj_lienurl}}" target="_blank"><x-bootstrap-icon iconname='link-45deg.svg'/></a>
    @endif
    {{$sous_objectif->ssobj_lib}}
</td>
<td>{{$sous_objectif->ssobj_duree}}</td>
<td>
    @if ($mode == "consultation" || ($mode== 'proposition' && $user->getTransformationManager()->aValideLeSousObjectif($sous_objectif) )  )
    @else
        <input type='checkbox' 
        x-data='{ active: false }'
        x-model="selected_sous_objectifs"
        value="{{$sous_objectif->id}}">
    @endif
    @php
        $comment=null;
        if ($mode!='modificationmultiple'){
            if (trim($user->getTransformationManager()->commentaireDeValidationDuSousObjectif($sous_objectif))){
                $comment=$user->getTransformationManager()->commentaireDeValidationDuSousObjectif($sous_objectif);
            }
            elseif (trim($user->getTransformationManager()->commentaireDePropositionDeValidationDuSousObjectif($sous_objectif))){
                $comment=$user->getTransformationManager()->commentaireDePropositionDeValidationDuSousObjectif($sous_objectif);
            }
        }
    @endphp
    @if ($mode!='consultation' && $comment)
        <span class="d-inline-block" data-bs-toggle="popover" data-bs-placement="right" 
                data-bs-content="{{$comment}}">
            <x-bootstrap-icon iconname='chat-left-quote.svg' />
        </span>
    @endif
    @if ($mode!='modificationmultiple'  && $user->getTransformationManager()->aValideLeSousObjectif($sous_objectif))
        <button class='btn btn-success' type='button' disabled>
        VALIDE {{ $user->getTransformationManager()->dateDeValidationDuSousObjectif($sous_objectif) }}
        </button>
    @endif
    @if ($mode!='modificationmultiple'  && $user->getTransformationManager()->aProposeLeSousObjectif($sous_objectif))
        <button class='btn btn-primary' type='button' disabled>
        PROPOSE {{ $user->getTransformationManager()->dateDePropositionDeValidationDuSousObjectif($sous_objectif) }}
        </button>
    @endif
</td>
@if ($mode!='modificationmultiple' && ( $user->getTransformationManager()->aValideLeSousObjectif($sous_objectif) || $user->getTransformationManager()->aProposeLeSousObjectif($sous_objectif) ) )
    <td>
        {{ $user->getTransformationManager()->valideurDeValidationDuSousObjectif($sous_objectif) }}
    </td>
@else
    <td>&nbsp;</td>
@endif
<td>{{$sous_objectif->lieu->lieu_libcourt}}</td>
</tr>