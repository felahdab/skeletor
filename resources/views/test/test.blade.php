@extends('layouts.app-master')

@section('content')
        <x-form::input name="name" label="Nom" placeholder="Nom..." type="text" value="{{ auth()->user()->name}}"/>
        <x-form::model-select name="grade" 
            :models="$grades" 
            label="Grade" 
            key-attribute="id" 
            value-attribute="grade_liblong"
            :value="auth()->user()->grade">
            <option value="">Grade</option>
        </x-form::model-select>
        <x-form::checkboxes name="actors[]" label="Rôles" :options="['lieven' => 'Lieven Scheire', 'jelle' => 'Jelle De Beule', 'jonas' => 'Jonas Geinaart']" type="checkbox" />
@endsection

