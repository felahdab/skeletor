@php
   $fonctionAQuai = $marin->fonctionAQuai();
@endphp
@if($fonctionAQuai)
    @php
        $pourcentage = $fonctionAQuai->pivot->taux_de_transformation;
    @endphp
    @if($fonctionAQuai->pivot->date_lache)
        <div style='color: green'>{{$fonctionAQuai->fonction_libcourt}} ( {{$fonctionAQuai->pivot->taux_de_transformation}}% ) 
        </div>
    @else
        @if ($pourcentage >= 70 )
            <div style='color: Goldenrod'>{{$fonctionAQuai->fonction_libcourt}} ( {{$fonctionAQuai->pivot->taux_de_transformation}}% )
            </div>
        @elseif ($pourcentage >= 35)
            <div style='color: orangered'>{{$fonctionAQuai->fonction_libcourt}} ( {{$fonctionAQuai->pivot->taux_de_transformation}}% )
            </div>
        @else
            <div style='color: red'>{{$fonctionAQuai->fonction_libcourt}} ( {{$fonctionAQuai->pivot->taux_de_transformation}}% )
            </div>
        @endif
    @endif
    
@endif
