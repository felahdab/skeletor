@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stage {{$stage->stage_libcourt}} - Situation des marins </h2>
    </div>
<div x-data="{ opendivvalid : false ,
	       date_validation : '{{date('Y-m-d') }}',
               commentaire : '' }">    
    <div x-cloak x-show="opendivvalid" id='divvalid' class='popupvalidcontrat' >
        <div class='titrenavbarvert'>
            <h5>Validation</h5>
        </div>
        <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
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
            x-on:click="opendivvalid=false;
                        $dispatch('uservalidated');">Valider</button>
            <button class='btn btn-primary w-25 mt-4 mb-2' type='reset' form='formlivret' id='btnresetobj' name='btnresetobj' x-on:click='opendivvalid = false;'>Annuler</button>
        </div>
    </div>
    
    <div id='divconsultstage' class='card bg-light ml-3 w-100'>
        <div class='card-header'>Consultation {{$stage->stage_libcourt}}
        </div>
        
        @if ($stage != null)
        {!! Form::open(['method' => 'POST','route' => ['stages.validermarins', $stage->id], 'id' => 'form']) !!}
        <input type='hidden' id='date_validation' name='date_validation' x-model="date_validation">
        <input type='hidden' id='commentaire'     name='commentaire'     x-model="commentaire">
        <input type='hidden' id='valideur'        name='valideur'        x-model="valideur">
        
        <div class='card border-primary mb-3'>
            <div class='card-header text-primary'>Liste des marins en attente du stage {{$stage->stage_libcourt}}</div>
            <div class='card-body'>
                <table class='table-hover' style='width:100%;'>
                    <tr style='background-color:#DCDCDC; font-weight: bold;'>
                        <td> Selection </td>
                        <td style='height:40px;'>Grd</td>
                        <td>Bvt</td>
                        <td>Sp&eacute;</td>
                        <td>Nom</td>
                        <td>Pr&eacute;nom</td>
                        @if(false)<td>Mat</td>@endif
                        <td>Secteur</td>
                        <td>Dest</td>
                        <td>Date mut</td>
                    </tr>
                    @foreach($usersdustage as $user)
                        @if ($user->pivot->date_validation == null)
                        <tr title='' style='color:black; '>
                            <td> <input type='checkbox' 
                                    id='user[{{ $user->id }}]' 
                                    name='user[{{ $user->id }}]' 
                                    value='user[{{ $user->id }}]'></td>
                            <td style='height:40px;'>{{$user->displayGrade()}} </td>
                            <td>{{$user->displayDiplome()}} </td>
                            <td>{{$user->displaySpecialite()}} </td>
                            <td><a href='{{ route("users.stages", $user->id) }}'>{{$user->name}} </a></td>
                            <td>{{$user->prenom}} </td>
                            @if(false)<td>{{$user->matricule}}</td>@endif
                            <td>{{$user->displaySecteur()}} </td>
                            <td>{{$user->displayDestination()}}</td>
                            <td>{{$user->displayDateDebarquement()}}</td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" 
                class="btn btn-primary w-50" 
		name="validation_double"
                x-on:click.prevent="opendivvalid=true">Valider les marins sélectionnés ci-dessus</button>
            <button x-show="false" type="submit" class="btn btn-primary w-50" 
		name="validation_double"
                x-on:uservalidated.window="$el.click()"></button>
        </div>
        {!! Form::close() !!}
        
        {!! Form::open(['method' => 'POST','route' => ['stages.annulermarins', $stage->id], 'id' => 'form']) !!}
        <input type='hidden' id='date_validation' name='date_validation' value=''>
        <input type='hidden' id='commentaire' name='commentaire' value=''>
        <input type='hidden' id='valideur' name='valideur' value=''>
        
        <div  class='card border-primary mb-3'>
            <div class='card-header text-primary'>Liste des marins ayant valid&eacute; le stage {{$stage->stage_libcourt}}</div>
            <div class='card-body'>
                <table class='table-hover' style='width:100%;'>
                    <tr style='background-color:#DCDCDC; font-weight: bold;'>
                        <td> Selection </td>
                        <td style='height:40px;'>Grd</td>
                        <td>Bvt</td>
                        <td>Sp&eacute;</td>
                        <td>Nom</td>
                        <td>Pr&eacute;nom</td>
                        @if(false)<td>Mat</td>@endif
                        <td>Secteur</td>
                        <td>Date valid</td>
                    </tr>
                    @foreach($usersdustage as $user)
                        @if ($user->pivot->date_validation != null)
                        <tr title='' style='color:black; '>
                            <td> <input type='checkbox' 
                                    id='usercancel[{{ $user->id }}]' 
                                    name='usercancel[{{ $user->id }}]' 
                                    value='usercancel[{{ $user->id }}]'></td>
                            <td style='height:40px;'>{{$user->displayGrade()}}   </td>
                            <td>{{$user->displayDiplome()}} </td>
                            <td>{{$user->displaySpecialite()}} </td>
                            <td><a href='{{ route("users.stages", $user->id) }}'>{{$user->name}} </a></td>
                            <td>{{$user->prenom}} </td>
                            @if(false)<td>{{$user->matricule}}</td>@endif
                            <td>{{$user->displaySecteur()}} </td>
                            <td>{{$user->pivot->date_validation}}</td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" 
                class="btn btn-danger" 
                name="validation_double">Dé-valider les marins sélectionnés ci-dessus</button>
        </div>
        {!! Form::close() !!}
        @endif
    </div>
    {!! link_to_route('transformation.indexparstage', 'Annuler', [], ['class' => 'btn btn-primary']) !!}
</div>
@endsection
