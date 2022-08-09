@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Modification utilisateur</h1>
        <div class="lead">
            
        </div>

        <div class="container mt-4">
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @method('patch')
                @csrf
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input value="{{ $user->email }}"
								type="email" 
								class="form-control" 
								name="email" 
								placeholder="Email address" required>
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
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="name" class="form-label">Nom</label>
							<input value="{{ $user->name }}" 
								type="text" 
								class="form-control" 
								name="name" 
								placeholder="Name" required>

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
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="prenom" class="form-label">Prenom</label>
							<input value="{{ $user->prenom }}" 
								type="text" 
								class="form-control" 
								name="prenom" 
								placeholder="Prenom" required>
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
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="matricule" class="form-label">Matricule</label>
							<input value="{{ $user->matricule }}" 
								type="text" 
								class="form-control" 
								name="matricule" 
								placeholder="Matricule" required>
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
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="mb-3">
							<label for="date_embarq" class="form-label">Date d'embarquement</label>
							<input value="{{ $user->date_embarq }}" 
								type="date" 
								class="form-control" 
								name="date_embarq" 
								placeholder="Date d'embarquement" required>
						</div>
					</div>
					<div class="col">
						<div class="mb-3">
							<label for="date_debarq" class="form-label">Date de debarquement</label>
							<input value="{{ $user->date_debarq }}" 
								type="date" 
								class="form-control" 
								name="date_debarq" 
								placeholder="Date de debarquement">
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

                <button type="submit" class="btn btn-primary">Update user</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection