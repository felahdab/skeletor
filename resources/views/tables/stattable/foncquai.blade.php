@php
   $fonctionAQuai = $marin->fonctionAQuai();
@endphp
@if($fonctionAQuai)
    @php
        $pourcentage = $fonctionAQuai->pivot->taux_de_transformation;
        $lache = $fonctionAQuai->pivot->date_lache != null;
    @endphp

    <x-ffast-fonction-text :text="$fonctionAQuai->fonction_libcourt" :pourcentage="$pourcentage" :lache="$lache"/>
@endif
