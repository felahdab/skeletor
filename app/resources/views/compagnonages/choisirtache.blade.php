@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Tâches</h2>
		<div class='lead'>Ajout d'une tâche pour le compagnonnage : {!!$compagnonage->comp_libcourt !!} </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
	
    @livewire('tache-list', ['compagnonage' => $compagnonage, 'mode' => 'selection'])
@endsection