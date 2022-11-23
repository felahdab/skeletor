@php
   $fonctionAMer = $marin->fonctionAMer();
@endphp
@if($fonctionAMer)
    @if($fonctionAMer->pivot->date_lache)
        <span style='color: green'>{{$fonctionAMer->fonction_libcourt}} ( {{$fonctionAMer->pivot->taux_de_transformation}}% ) 
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
        }' x-bind:style='getColor({{$fonctionAMer->pivot->taux_de_transformation}})'>{{$fonctionAMer->fonction_libcourt}} ( {{$fonctionAMer->pivot->taux_de_transformation}}% )
        </span>
    @endif
@endif

