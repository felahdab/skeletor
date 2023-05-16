@props(['heading' => ''])

<div class="p-4 rounded">
   <h2>{{ $heading }}</h2>

   {{ $slot }}

</div>