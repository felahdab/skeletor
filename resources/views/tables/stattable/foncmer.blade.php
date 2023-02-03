@php
   $fonctionAMer = $marin->fonctionAMer();
@endphp
@if($fonctionAMer)
    @php
        $pourcentage = $fonctionAMer->pivot->taux_de_transformation;
        $lache = $fonctionAMer->pivot->date_lache != null;
    @endphp
    <x-ffast-fonction-text :text="$fonctionAMer->fonction_libcourt" :pourcentage="$pourcentage" :lache="$lache"/>
@endif

