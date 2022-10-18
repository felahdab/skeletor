@php
   $fonctionAMer = $marin->fonctionAMer();
@endphp
<span style='@if($fonctionAMer != null){!! $marin->getFonctionHtmlAttribute($fonctionAMer) !!}@else'@endif
</span>
