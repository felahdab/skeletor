@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')
<x-content-div heading="Recherche Annudef">
    <div class="mt-3">
        <livewire:annudef-search mode="recherche">
    </div>
</x-content-div>
@endsection