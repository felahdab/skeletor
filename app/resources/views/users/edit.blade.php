@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Modification utilisateur</h1>
        <div class="lead">
            
        </div>

        <div class="container mt-4">
			{!! Form::open(['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							{!!Form::email('email', $user->email , ['class' => 'form-control', 'placeholder'=> "Adresse email", 'required']) !!}
							@if ($errors->has('email'))
								<span class="text-danger text-left">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="col">
						<div class="mb-3">
							<label for="grade" class="form-label">Grade</label>
							<select class="form-control" 
								name="grade" required>
								<option value="0">Grade</option>
								@foreach($grades as $grade)
									<option value="{{ $grade->id }}" {{ $user->grade_id == $grade->id
											? ' selected'
											: '' }}>
										{{ $grade->grade_liblong }}
										{{ $user->grade_id == $grade->id
											? ' (grade actuel)'
											: '' }}  </option>
								@endforeach
							</select>
							@if ($errors->has('grade'))
								<span class="text-danger text-left">{{ $errors->first('grade') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="name" class="form-label">Nom</label>
							{!!Form::text('name', $user->name , ['class' => 'form-control', 'placeholder'=> "Nom", 'required']) !!}
							@if ($errors->has('name'))
								<span class="text-danger text-left">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="col">
						<div class="mb-3">
							<label for="specialite" class="form-label">Specialite</label>
							<select class="form-control" 
								name="specialite" required>
								<option value="0">Specialite</option>
								@foreach($specialites as $specialite)
									<option value="{{ $specialite->id }}" {{ $user->specialite_id == $specialite->id
											? ' selected'
											: '' }}>
										{{ $specialite->specialite_libcourt }}
										{{ $user->specialite_id == $specialite->id
											? ' (specialite actuelle)'
											: '' }}  </option>
								@endforeach
							</select>
							@if ($errors->has('specialite'))
								<span class="text-danger text-left">{{ $errors->first('specialite') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="prenom" class="form-label">Prenom</label>
							{!!Form::text('prenom', $user->prenom , ['class' => 'form-control', 'placeholder'=> "Prénom", 'required']) !!}
							@if ($errors->has('prenom'))
								<span class="text-danger text-left">{{ $errors->first('prenom') }}</span>
							@endif
						</div>
					</div>
					<div class="col">
						<div class="mb-3">
							<label for="secteur" class="form-label">Secteur</label>
							<select class="form-control" 
								name="secteur" required>
								<option value="0">Secteur</option>
								@foreach($secteurs as $secteur)
									<option value="{{ $secteur->id }}" {{ $user->secteur_id == $secteur->id
											? ' selected'
											: '' }}>
										{{ $secteur->displayName() }}
										{{ $user->secteur_id == $secteur->id
											? ' (secteur actuel)'
											: '' }}  </option>
								@endforeach
							</select>
							@if ($errors->has('secteur'))
								<span class="text-danger text-left">{{ $errors->first('secteur') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="matricule" class="form-label">Matricule</label>
							{!!Form::text('matricule', $user->matricule , ['class' => 'form-control', 'placeholder'=> "Matricule", 'required']) !!}
							@if ($errors->has('matricule'))
								<span class="text-danger text-left">{{ $errors->first(matricule) }}</span>
							@endif
						</div>
					</div>
					<div class="col">
						<div class="mb-3">
							<label for="specialite" class="form-label">Brevet</label>
							<select class="form-control" 
								name="diplome" required>
								<option value="0">Brevet</option>
								@foreach($diplomes as $diplome)
									<option value="{{ $diplome->id }}" {{ $user->diplome_id == $diplome->id
											? ' selected'
											: '' }}>
										{{ $diplome->diplome_libcourt }}
										{{ $user->diplome_id == $diplome->id
											? ' (diplome actuel)'
											: '' }}  </option>
								@endforeach
							</select>
							@if ($errors->has('specialite'))
								<span class="text-danger text-left">{{ $errors->first(specialite) }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="date_embarq" class="form-label">Date d'embarquement</label>
							{!!Form::date('date_embarq', $user->date_embarq , ['class' => 'form-control', 'placeholder'=> 'Date d\'embarquement', 'required']) !!}
							@if ($errors->has('date_embarq'))
								<span class="text-danger text-left">{{ $errors->first(date_embarq) }}</span>
							@endif
						</div>
					</div>
					<div class="col">
						<div class="mb-3">
							<label for="date_debarq" class="form-label">Date de debarquement</label>
							{!!Form::date('date_debarq', $user->date_debarq , ['class' => 'form-control', 'placeholder'=> 'Date de debarquement', 'required']) !!}
							@if ($errors->has('date_debarq'))
								<span class="text-danger text-left">{{ $errors->first(date_debarq) }}</span>
							@endif
						</div>
					</div>
				</div>
				
				<div class="mb-3">
					<label for="unite_destination" class="form-label">Unité destination</label>
					<select class="form-control" 
						name="unite_destination" required>
						<option value="0">Unité destination</option>
						@foreach($unites as $unite)
							<option value="{{ $unite->id }}" {{ $user->unite_destination_id == $unite->id
									? ' selected'
									: '' }}>
								{{ $unite->unite_liblong }}
								{{ $user->unite_destination_id == $unite->id
									? ' (unite actuelle)'
									: '' }}  </option>
						@endforeach
					</select>
					@if ($errors->has('unite_destination'))
						<span class="text-danger text-left">{{ $errors->first(unite_destination) }}</span>
					@endif
				</div>
				
                <label for="roles" class="form-label">Attribuer des roles</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" name="all_roles"></th>
                        <th scope="col" width="20%">Nom</th>
                    </thead>

                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                name="role[{{ $role->name }}]"
                                value="{{ $role->name }}"
                                class='role'
                                {{ in_array($role->name, $userRole) 
                                    ? 'checked'
                                    : '' }}>
                            </td>
                            <td>{{ $role->name }}</td>
                        </tr>
                    @endforeach
                </table>
				@if ($errors->has('role'))
					<span class="text-danger text-left">{{ $errors->first(role) }}</span>
				@endif

                {!! Form::button('Mettre à jour', ['class'=>'btn btn-primary']) !!}
				{!! link_to_route('users.index', 'Annuler', [], ['class' => 'btn btn-default']) !!}
            {!! Form::close() !!}
        </div>

    </div>
@endsection