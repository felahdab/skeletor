@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="statistiques"/>
@endsection


@section('content')
        <div style='text-align: center;margin-top: 25px;margin-bottom: 25px;'>
            <h1>Dashboard</h1>
        </div>
        <div>
            <livewire:dashboard>
        </div>
        
@endsection
