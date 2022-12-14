@php
   $fonctionAMer = $marin->fonctionAMer();
@endphp
@if($fonctionAMer)
    @php
        $pourcentage = $fonctionAMer->pivot->taux_de_transformation;
    @endphp

    @if($fonctionAMer->pivot->date_lache)
        <div style='color: green'>{{$fonctionAMer->fonction_libcourt}} ( {{$fonctionAMer->pivot->taux_de_transformation}}% ) 
        </div>
    @else
        @if ($pourcentage >= 70 )
            <div style='color: Goldenrod'>{{$fonctionAMer->fonction_libcourt}} ( {{$fonctionAMer->pivot->taux_de_transformation}}% )
            </div>
        @elseif ($pourcentage >= 35)
            <div style='color: orangered'>{{$fonctionAMer->fonction_libcourt}} ( {{$fonctionAMer->pivot->taux_de_transformation}}% )
            </div>
        @else
            <div style='color: red'>{{$fonctionAMer->fonction_libcourt}} ( {{$fonctionAMer->pivot->taux_de_transformation}}% )
            </div>
        @endif
    @endif
    
    
@endif

