@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="transformation"/>
@endsection


@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Situation des marins pour le stage : {{$stage->stage_libcourt}}</h2>
        @if(auth()->user()->can('stages.attribuerstage'))
            Commentaire : {{$stage->commentaire}}
        @endif
    </div>
<div x-data="{ opendivvalid : false ,
	       date_validation : '{{date('Y-m-d') }}',
               commentaire : '' }">    

    <div class="modal fade" id="divvalid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Validation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
                <div class='form-group row pl-3 mt-2' >
                    <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
                    <div class='col-sm-5'>
                    <input type='date' class='form-control'name='date_validation' id='date_validation' x-model="date_validation">
                    </div>
                </div>
                <div class='form-group row  pl-3' >
                        <textarea class="w-100"  rows='4' name='commentaire' id='commentaire' placeholder='Commentaire' x-model="commentaire"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" 
                        class="btn btn-primary"
                        x-on:click="opendivvalid=false;
                        $dispatch('uservalidated');">Valider</button>
            </div>
            </div>
        </div>
    </div>

    <div id='divconsultstage'>
        @if ($stage != null)
        {!! Form::open(['method' => 'POST','route' => ['stages.validermarins', $stage->id], 'id' => 'form']) !!}
        <input type='hidden' id='date_validation' name='date_validation' x-model="date_validation">
        <input type='hidden' id='commentaire'     name='commentaire'     x-model="commentaire">
        <input type='hidden' id='valideur'        name='valideur'        x-model="valideur">
        
        <div>
            @php
                $nbmarinsattente=0;
                foreach($usersdustage as $user){
                        if ($user->pivot->date_validation == null) 
                            $nbmarinsattente++;
                }
            @endphp
            <div class='lead'>Liste des <b>{{$nbmarinsattente}}</b> marins <b>en attente</b> du stage {{$stage->stage_libcourt}}</div>
            <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                        <tr style='background-color:silver; font-weight: bold;'>
                            <th scope="col">&#10003;</th>
                            <th scope="col">Grd</th>
                            <th scope="col">Bvt</th>
                            <th scope="col">Sp&eacute;</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Pr&eacute;nom</th>
                            <th scope="col">Mat</th>
                            <th scope="col">NID</th>
                            <th scope="col">Secteur</th>
                            <th scope="col">Mut</th>
                            <th scope="col">Date mut</th>
                            @if(auth()->user()->can('stages.attribuerstage'))
                                <th scope="col">&#10069;</th>
                                <th scope="col">&#128822;</th>
                            @endif
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($usersdustage as $user)
                        @if ($user->pivot->date_validation == null)
                        <tr title="{{$user->user_comment}}">
                            <td> <input type='checkbox' 
                                    id='user[{{ $user->id }}]' 
                                    name='user[{{ $user->id }}]' 
                                    value='user[{{ $user->id }}]'></td>
                            <td style='height:40px;'>{{$user->displayGrade()}} </td>
                            <td>{{$user->displayDiplome()}} </td>
                            <td>{{$user->displaySpecialite()}} </td>
                            <td><a href='{{ route("users.stages", $user->id) }}'>{{$user->name}} </a></td>
                            <td>{{$user->prenom}} </td>
                            <td>{{$user->matricule}}</td>
                            <td>{{$user->nid}}</td>
                            <td>{{$user->displaySecteur()}} </td>
                            <td>{{$user->displayDestination()}}</td>
                            <td>{{$user->displayDateDebarquement()}}</td>
                            @if(auth()->user()->can('stages.attribuerstage'))
                                @if ($user->pivot->commentaire == null or $user->pivot->commentaire == ' ')
                                    <td>&nbsp;</td>
                                @else
                                    <td title="{{$user->pivot->commentaire}}">&#10069;</td>
                                @endif
                                @if ($user->user_comment == null or $user->user_comment == ' ')
                                    <td>&nbsp;</td>
                                @else
                                    <td title="{{$user->user_comment}}"> 	&#128822;</td>
                                @endif
                            @endif
                            
                            <td>{{$user->email}}</td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @can('stages.validermarins')
            <div class="text-center">
                <button type="submit" 
                    class="btn btn-primary w-50" 
                    name="validation_double"
                    x-on:click.prevent="validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                    validModal.show();">Valider les marins sélectionnés ci-dessus</button>
                <button x-show="false" type="submit" class="btn btn-primary w-50" 
            name="validation_double"
                    x-on:uservalidated.window="$el.click()"></button>
            </div>
        @endcan
        {!! Form::close() !!}
        
        {!! Form::open(['method' => 'POST','route' => ['stages.annulermarins', $stage->id], 'id' => 'form']) !!}
        <input type='hidden' id='date_validation' name='date_validation' value=''>
        <input type='hidden' id='commentaire' name='commentaire' value=''>
        <input type='hidden' id='valideur' name='valideur' value=''>
        
        <div  class='card border-primary mb-3 mt-3'>
            <div class='card-header'>Liste des marins ayant <b>valid&eacute;</b> le stage {{$stage->stage_libcourt}}</div>
            <div class='card-body'>
                <table class='table table-striped' style='width:100%;'>
                    <tr style='background-color:silver; font-weight: bold;'>
                        <td>&#10003;</td>
                        <td style='height:40px;'>Grd</td>
                        <td>Bvt</td>
                        <td>Sp&eacute;</td>
                        <td>Nom</td>
                        <td>Pr&eacute;nom</td>
                        @if(false)<td>Mat</td>@endif
                        <td>Secteur</td>
                        <td>Date valid</td>
                        @if(auth()->user()->can('stages.attribuerstage'))
                                <th scope="col">&#10069;</th>
                                <th scope="col">&#128822;</th>
                        @endif
                    </tr>
                    <tbody>
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
                            @if(auth()->user()->can('stages.attribuerstage'))
                                @if ($user->pivot->commentaire == null or $user->pivot->commentaire == ' ')
                                    <td>&nbsp;</td>
                                @else
                                    <td title="{{$user->pivot->commentaire}}">&#10069;</td>
                                @endif
                                @if ($user->user_comment == null or $user->user_comment == ' ')
                                    <td>&nbsp;</td>
                                @else
                                    <td title="{{$user->user_comment}}">&#128822;</td>
                                @endif
                            @endif
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @can('stages.annulermarins')
            <div class="text-center  mb-3">
                <button type="submit" 
                    class="btn btn-danger" 
                    name="validation_double">Dé-valider les marins sélectionnés ci-dessus</button>
            </div>
        @endcan
        {!! Form::close() !!}
        @endif
    </div>
        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Annuler</a>
</div>
@endsection
