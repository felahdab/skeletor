@php
    $fonctionsMetier = $marin->fonctionsMetier()->get();
@endphp
<div>
    <ul style='list-style-type : none;' >
        @foreach($fonctionsMetier as $fonction)
            @php
                $pourcentage = $fonction->pivot->taux_de_transformation;
                $lache = $fonction->pivot->date_lache != null;
            @endphp
            <x-ffast-fonction-text :text="$fonction->fonction_libcourt" :pourcentage="$pourcentage" :lache="$lache"/>
        @endforeach
    </ul>
</div>