@props(['page' => '', 'module' => "Skeletor"])

<div>
   <a href="{{ url(env('APP_PREFIX') . '/docs/' . $module . '/' . $page . '.md') }}" class="dropdown-item" >Aide</a>
</div>
