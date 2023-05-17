@php
    $fonctionAMer = $marin->fonctionAMer()->get();
@endphp
<div>
        @foreach($fonctionAMer as $fonction)
            @php
                $pourcentage = $fonction->pivot->taux_de_transformation;
                $lache = $fonction->pivot->date_lache != null;
            @endphp
            <x-ffast-fonction-text :text="$fonction->fonction_libcourt" :pourcentage="$pourcentage" :lache="$lache"/>
        @endforeach
</div>

