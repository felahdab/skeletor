@php
    $fonctionsMetier = $marin->fonctionsMetier()->get();
@endphp
<div>
    <ul style='list-style-type : none;' >
        @foreach($fonctionsMetier as $fonction)
            @php
                $pourcentage = $fonction->pivot->taux_de_transformation
            @endphp
            @if($fonction->pivot->date_lache)
                <li style='margin-bottom: 3px; color: green'>{{$fonction->fonction_libcourt}} ( {{$fonction->pivot->taux_de_transformation}}% ) 
                </li>
            @else
                @if ($pourcentage >= 70 )
                    <li style='margin-bottom: 3px; color: Goldenrod'>{{$fonction->fonction_libcourt}} ( {{$fonction->pivot->taux_de_transformation}}% ) 
                    </li>
                @elseif ($pourcentage >= 35)
                    <li style='margin-bottom: 3px; color: orangered'>{{$fonction->fonction_libcourt}} ( {{$fonction->pivot->taux_de_transformation}}% ) 
                    </li>
                @else
                    <li style='margin-bottom: 3px; color: red'>{{$fonction->fonction_libcourt}} ( {{$fonction->pivot->taux_de_transformation}}% ) 
                    </li>
                @endif
            @endif
            
        @endforeach
    </ul>
</div>