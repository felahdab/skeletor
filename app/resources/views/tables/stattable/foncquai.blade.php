@php
   $fonctionAQuai = $marin->fonctionAQuai();
@endphp
@if($fonctionAQuai)
    @if($fonctionAQuai->pivot->date_lache)
        <span style='color: green'>{{$fonctionAQuai->fonction_libcourt}} ( {{$fonctionAQuai->pivot->taux_de_transformation}}% ) 
        </span>
    @else
        <span x-data='{
            getColor(p){
                if (p >= 70){
                    return "color: Goldenrod";}
                else if(p >= 35){
                    return "color: orangered";}
                else {
                    return  "color: red";}
            }
        }' x-bind:style='getColor({{$fonctionAQuai->pivot->taux_de_transformation}})'>{{$fonctionAQuai->fonction_libcourt}} ( {{$fonctionAQuai->pivot->taux_de_transformation}}% )
        </span>
    @endif
@endif
