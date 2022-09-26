@extends('layouts.app-master')

@section('content')
<div class="bg-light p-4 rounded">
        <h1>Changer de role</h1>
	<div class="container mt-4">
	<form method="post" action="{{ route('currentrole.store', $user->id) }}">
		@csrf
		<div class="mb-3">
			<label for="role" class="form-label">Role</label>
			<select class="form-control" 
				name="role" required>
				<option value="">Choisir le role</option>
				@foreach($userRole as $role)
					<option value="{{ $role->id }}">
						{{ $role->name }}
						{{ session()->get('current_role') == $role->id
							? ' (role actuel)'
							: '' }}  </option>
				@endforeach
			</select>
			@if ($errors->has('role'))
				<span class="text-danger text-left">{{ $errors->first('role') }}</span>
			@endif
		</div>
		<button type="submit" class="btn btn-primary">Mettre a jour</button>
		<a href="{{ route('home.index') }}" class="btn btn-default">Annuler</button>
	</form>
</div>
</div>
@endsection