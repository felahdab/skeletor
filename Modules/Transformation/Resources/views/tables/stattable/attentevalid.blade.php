@php
     $nb_ssobj_attente = $marin->sous_objectifs()->whereNotNull('date_proposition_validation')->count();
     $nb_lache_attente = $marin->fonctions()->whereNotNull('date_proposition_lache')->count();
     $nb_double_attente = $marin->fonctions()->whereNotNull('date_proposition_double')->count();
     $nb_attente = $nb_lache_attente + $nb_ssobj_attente + $nb_double_attente;
@endphp
@if($nb_attente >0 )
     <span class="text-info"><x-bootstrap-icon iconname='envelope-paper-fill.svg' /></span>
@else
     &nbsp;
@endif