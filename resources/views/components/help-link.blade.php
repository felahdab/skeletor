@props(['page' => '', 'module' => "Skeletor"])

<div>
   <a href="{{ url(config('skeletor.prefixe_instance') . '/docs/' . $module . '/' . $page . '.md') }}" class="dropdown-item" >Aide</a>
</div>
