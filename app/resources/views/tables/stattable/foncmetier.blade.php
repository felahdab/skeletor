@php
    $fonctionsMetier = $marin->fonctionsMetier()->get();
@endphp
<span>
    <ul style='list-style-type : none;'>
        @foreach($fonctionsMetier as $fonction)
            <li style='margin-bottom: 3px;{!! $marin->getFonctionHtmlAttribute($fonction) !!}</li>
        @endforeach
    </ul>
</span>