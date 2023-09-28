@extends('layouts.app-master')

@section('content')
    <div class="w-100">
        @php
            use Modules\Transformation\Entities\MiseEnVisibilite;
            $mpes = MiseEnVisibilite::with('user')->orderBy('user_id')->get();
        @endphp
        <livewire:transformation::planning-mpe :mpes='$mpes'>
    </div>
@endsection
