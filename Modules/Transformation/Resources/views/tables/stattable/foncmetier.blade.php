@php
    $fonctionsMetier = $marin->fonctionsMetier()->get();
@endphp
<div>
        @foreach($fonctionsMetier as $fonction)
            @php
                $pourcentage = $fonction->pivot->taux_de_transformation;
                $lache = $fonction->pivot->date_lache != null;
            @endphp
            <x-transformation::ffast-fonction-text :text="$fonction->fonction_libcourt" :pourcentage="$pourcentage" :lache="$lache"/>
        @endforeach
</div>