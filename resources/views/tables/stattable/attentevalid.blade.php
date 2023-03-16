@php
     $nb_ssobj_attente = $marin->sous_objectifs()->whereNotNull('date_proposition_validation')->count();
     //$nb_lache_attente = 
@endphp
@if($nb_ssobj_attente >0 )
     <span>&#9993;</span><!--enveloppe-->
     <span><img src='{{ asset("assets/images/enveloppe.png") }}' alt="enveloppe" ></span>
@else
     <span></span><!-- -->
@endif