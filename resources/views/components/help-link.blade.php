@props(['page' => '', 'module' => "Skeletor"])

<div>
   <a href="{{ url(config('skeletor.instance_prefix') . '/docs/' . $module . '/' . $page . '.md') }}" class="dropdown-item" >Aide</a>
</div>
