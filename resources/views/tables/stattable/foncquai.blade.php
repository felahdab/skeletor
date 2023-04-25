@php
    $fonctionsAQuai = $marin->fonctionAQuai()->get();
@endphp
<div>
    <ul style='list-style-type : none;' >
        @foreach($fonctionsAQuai as $fonction)
            @php
                $pourcentage = $fonction->pivot->taux_de_transformation;
                $lache = $fonction->pivot->date_lache != null;
            @endphp
            <x-ffast-fonction-text :text="$fonction->fonction_libcourt" :pourcentage="$pourcentage" :lache="$lache"/>
        @endforeach
    </ul>
</div>