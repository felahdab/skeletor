@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages - Visualisation des stages et des marins concernés</h2>
    </div>
    
    <div id='divconsultstage' class='card bg-light ml-3 w-100'>
        <div class='card-header'>Consultation {{$stage->stage_libcourt}}
        </div>
        
        <div style='padding-left: 15px;'>
            <div class='flex' style='justify-content: start;'>
                <div class='form-group row w-50 mt-3'>
                    <label for='liststages' class='col-sm-5 col-form-label'> Stage </label>
                    <select name='liststageconsult' id='liststageconsult' class='custom-select  w-50' onchange=' modifdeuxparam("stage","liststageconsult","marin");'>
                        <option value ='0' >S&eacute;lectionner le stage</option>
                        @foreach($stages as $stageexistant)
                        <option value ='{{$stageexistant->id}}' @selected($stage != null and $stageexistant->id == $stage->id)>{{$stageexistant->stage_libcourt}}</option>
                        @endforeach
                    </select>
                </div>
                <div class='form-group row w-50 mt-3' >
                </div>
            </div>
        </div>
        
        @if ($stage != null)
        <div class='card border-primary mb-3'>
            <div class='card-header text-primary'>Liste des marins en attente du stage {{$stage->stage_libcourt}}</div>
            <div class='card-body'>
                <table class='table-hover' style='width:100%;'>
                    <tr style='background-color:#DCDCDC; font-weight: bold;'>
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
        <div  class='card border-primary mb-3'>
            <div class='card-header text-primary'>Liste des marins ayant valid&eacute; le stage {{$stage->stage_libcourt}}</div>
            <div class='card-body'>
                <table class='table-hover' style='width:100%;'>
                    <tr style='background-color:#DCDCDC; font-weight: bold;'>
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
        
        @endif
    </div>
    {!! link_to_route('transformation.index', 'Annuler', [], ['class' => 'btn btn-primary']) !!}
@endsection