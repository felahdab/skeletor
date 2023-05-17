@props(['page' => '', 'version' => env('DOC_VERSION')])

<div>
   <a href="{{ route('larecipe.show', ['version' => $version, 'page' => $page]) }}" class="dropdown-item" >Aide</a>
</div>
