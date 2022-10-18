@php
   $fonctionAQuai = $marin->fonctionAQuai();
@endphp
<span style='@if($fonctionAQuai != null){!! $marin->getFonctionHtmlAttribute($fonctionAQuai) !!}@else'>@endif
</span>
