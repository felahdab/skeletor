@extends('layouts.app-master')

@section('helplink')
<x-help-link page="generalites"/>
@endsection


@section('content')

<livewire:main-user-preferences  />

@endsection