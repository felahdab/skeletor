@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages - Validation ou annulation collective du stage {{$stage->stage_libcourt}}</h2>
    </div>
<div x-data="{ opendivvalid : false ,
               commentaire   :    '' ,
               valideur      :    '' ,
               date_validation : '{{ date('Y-m-d') }}' }">
        <div x-cloak x-show="opendivvalid" id='divvalid' class='popupvalidcontrat'>
            <div class='titrenavbarvert'>
                <h5>Validation</h5>
            </div>
            <div class='form-group row pl-3 mt-2' >
                <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
                <div class='col-sm-5'>
                <input type='date' class='form-control'name='date_validation' id='date_validation' x-model="date_validation">
                </div>
            </div>
            <div class='form-group row  pl-3' >
                <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
                <div class='col-sm-5'>
                    <textarea cols='40' rows='4' name='commentaire' id='commentaire' placeholder='Commentaire' x-model="commentaire"></textarea>
                </div>
            </div>
            <div class='text-center'>
                <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
                id='btnvalidobj' 
		name='btnvalidobj'
                x-on:click="$dispatch('uservalidated');">Valider</button>
                <button class='btn btn-primary w-25 mt-4 mb-2' type='reset' form='formlivret' id='btnresetobj' name='btnresetobj' x-on:click="opendivvalid=false;">Annuler</button>
            </div>
        </div>

    <div class='flex' style='justify-content: start;'>
        <div class="container mt-4 w-50" x-data='{allChecked : false }'>
            <div>
                {!! Form::open(['method' => 'POST','route' => ['stages.validermarins', $stage->id], 'id' => 'form']) !!}
                <input type='hidden' id='date_validation' name='date_validation' value='' x-model="date_validation">
                <input type='hidden' id='commentaire' name='commentaire' value='' x-model="commentaire">
                <input type='hidden' id='valideur' name='valideur' value='' x-model="valideur">
                
                <label for="roles" class="form-label">Choisir les marins pour lesquels enregistrer la validation du stage</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" x-on:click="allChecked = !allChecked; $dispatch('toggleallusers');"></th>
                        <th scope="col" width="20%">Nom</th>
                    </thead>
                    @foreach($usersdustage as $user)
                            @if ($user->stages()->find($stage) != null and $user->stages()->find($stage)->pivot->date_validation == null)
                            <tr>
                                <td>
                                    <input type="checkbox" 
                                    name="user[{{ $user->id }}]"
                                    value="user[{{ $user->id }}]"
				    class='user'
                                    x-on:toggleallusers.window="$el.checked = allChecked;">
                                </td>
                                <td>{{ $user->display_name }}</td>
                            </tr>
                            @endif
                    @endforeach
                </table>
                <button type="submit" 
                    class="btn btn-primary" 
		    name="validation_double"
		    x-on:click.prevent="opendivvalid = true;">Valider</button>
                <button type="submit" x-show="false"
                    x-on:uservalidated.window="$el.click()"></button>
                {!! link_to_route('stages.index', 'Annuler', [], ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
            </div>
            
            {!! Form::open(['method' => 'POST','route' => ['stages.attribuerstage', $stage->id]]) !!}
            <label for="fonction" class="form-label">Marin supplémentaire</label>
            <select class="form-control" 
                name="user_id" required>
                <option value="0">Marin supplémentaire</option>
                @foreach($users as $user)
                    @if ($user->stages()->find($stage) == null)
                    <option value="{{ $user->id }}">
                    {{ $user->display_name }}
                    </option>
                    @endif
                @endforeach
            </select>

            {!! Form::button('Rajouter ce marin', ['type'=> 'submit', 'class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        
        <div class="container mt-4  w-50" x-data='{ allChecked : false }'>
            {!! Form::open(['method' => 'POST','route' => ['stages.annulermarins', $stage->id], 'id' => 'form']) !!}
            <input type='hidden' id='date_validation' name='date_validation' value=''>
            <input type='hidden' id='commentaire' name='commentaire' value=''>
            <input type='hidden' id='valideur' name='valideur' value=''>
            
            <label for="roles" class="form-label">Choisir les marins qui ont validé le stage et pour lesquels il faut annuler</label>

            <table class="table table-striped">
                <thead>
                    <th scope="col" width="1%"><input type="checkbox" x-on:click="allChecked = ! allChecked; $dispatch('toggleallusers');"></th>
                    <th scope="col" width="20%">Nom</th>
                    <th scope="col" width="20%">Date de validation</th>
                </thead>
                @foreach($usersdustage as $user)
                        @if ($user->stages()->find($stage) != null and $user->stages()->find($stage)->pivot->date_validation != null)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                name="usercancel[{{ $user->id }}]"
                                value="usercancel[{{ $user->id }}]"
				class='user'
                                x-on:toggleallusers.window="$el.checked=allChecked">
                            </td>
                            <td>{{ $user->display_name }}</td>
                            <td>{{ $user->stages()->find($stage)->pivot->date_validation }}</td>
                        </tr>
                        @endif
                @endforeach
            </table>
            <button type="submit" 
                class="btn btn-primary" 
                name="validation_double">Valider</button>
            {!! link_to_route('stages.index', 'Annuler', [], ['class' => 'btn btn-default']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    </div>
</div>
@endsection

