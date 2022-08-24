@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>

        <div id='divvalid' class='popupvalidcontrat' style='display:none;'>
            <div class='titrenavbarvert'>
                <h5>Validation</h5>
            </div>
            <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
            <div class='form-group row pl-3 mt-2' >
                <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
                <div class='col-sm-5'>
                <input type='date' class='form-control'name='date_validation' id='date_validation' value='2022-08-14'>
                </div>
            </div>
            <div class='form-group row  pl-3' >
                <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
                <div class='col-sm-5'>
                    <textarea cols='40' rows='4' name='commentaire' id='commentaire' placeholder='Commentaire'></textarea>
                </div>
            </div>
            <div class='text-center'>
                <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
                id='btnvalidobj' 
                name='btnvalidobj'
                onclick='divvalid = getElementById("divvalid");
                        formtosubmitid=divvalid.querySelector("#formtosubmit").value;
                        formtosubmit = getElementById(formtosubmitid);
                        formtosubmit.querySelector("#commentaire").value = divvalid.querySelector("#commentaire").value;
                        formtosubmit.querySelector("#date_validation").value = divvalid.querySelector("#date_validation").value;
                        formtosubmit.submit();'
                            >Valider</button>
                <button class='btn btn-primary w-25 mt-4 mb-2' type='reset' form='formlivret' id='btnresetobj' name='btnresetobj' onclick='annuler("divvalid");'>Annuler</button>
            </div>
        </div>

        <div class="container mt-4">
            {!! Form::open(['method' => 'POST','route' => ['stages.validermarins', $stage->id], 'id' => 'form']) !!}
            <input type='hidden' id='date_validation' name='date_validation' value=''>
            <input type='hidden' id='commentaire' name='commentaire' value=''>
            <input type='hidden' id='valideur' name='valideur' value=''>
            
            <label for="roles" class="form-label">Choisir les marins pour lesquels le stage est désormais validé</label>

            <table class="table table-striped">
                <thead>
                    <th scope="col" width="1%"><input type="checkbox" name="all_users"></th>
                    <th scope="col" width="20%">Nom</th>
                </thead>
                @foreach($stage->users()->get() as $user)
                        @if ($user->stages()->find($stage) != null and $user->stages()->find($stage)->pivot->date_validation == null)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                name="user[{{ $user->id }}]"
                                value="user[{{ $user->id }}]"
                                class='user'>
                            </td>
                            <td>{{ $user->displayString() }}</td>
                        </tr>
                        @endif
                @endforeach
            </table>
            <button type="submit" 
                class="btn btn-primary" 
                name="validation_double"
                onclick='divvalid = getElementById("divvalid");
                        parentForm = jQuery(this).closest("form");
                        divvalid.querySelector("#formtosubmit").value=parentForm[0].id;
                        affichage("divvalid");
                        return false;'>Valider</button>
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
                {{ $user->displayString() }}
                </option>
                @endif
            @endforeach
        </select>

        {!! Form::button('Rajouter ce marin', ['type'=> 'submit', 'class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
        
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_users"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.user'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.user'), function() {
                        $(this).prop('checked',false);
                    });
                }
                
            });
        });
    </script>
@endsection