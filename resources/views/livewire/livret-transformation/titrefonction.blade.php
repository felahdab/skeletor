@if ($mode!= "modificationmultiple")
    @if ($fonction->pivot->date_lache != null)
        <span class="text-success"><x-bootstrap-icon iconname='check-circle.svg'/></span>
    @endif
    @if ($fonction->pivot->date_proposition_lache != null
        OR $fonction->pivot->date_proposition_double != null
        OR $user->getTransformationManager()->sous_objectifs_du_parcours_proposes($fonction)->count() > 0)
        <span class="text-info"><x-bootstrap-icon iconname='envelope-paper-fill.svg' /></span>
    @endif
@endif
{{ $fonction->fonction_liblong }} 
