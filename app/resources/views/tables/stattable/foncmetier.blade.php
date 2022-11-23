@php
    $fonctionsMetier = $marin->fonctionsMetier()->get();
@endphp
<span>
    <ul style='list-style-type : none;' x-data='{
            getColor(p){
                if (p >= 70){
                    return "color: Goldenrod";}
                else if(p >= 35){
                    return "color: orangered";}
                else {
                    return  "color: red";}
            }
        }'>
        @foreach($fonctionsMetier as $fonction)
            @if($fonction->pivot->date_lache)
                <li style='margin-bottom: 3px; color: green'>{{$fonction->fonction_libcourt}} ( {{$fonction->pivot->taux_de_transformation}}% ) 
                </li>
            @else
                <li style='margin-bottom: 3px;' x-bind:style='getColor({{$fonction->pivot->taux_de_transformation}})'>{{$fonction->fonction_libcourt}} ( {{$fonction->pivot->taux_de_transformation}}% )
                </li>
            @endif
        @endforeach
    </ul>
</span>