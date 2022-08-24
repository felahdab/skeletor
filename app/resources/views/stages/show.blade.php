@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    
    <div id='divconsultstage' class='card bg-light ml-3 w-100'>
        <div class='card-header'>Consultation @if($marin==null) {{$stage->stage_libcourt}} @else {{$marin->displayString()}} @endif</div>
        <div style='padding-left: 15px;'>
            <div class='form-group row w-50 float-left  mt-3'>
                <label for='liststages' class='col-sm-5 col-form-label'> Stage </label>
                <select name='liststageconsult' id='liststageconsult' class='custom-select  w-50' onchange=' modifdeuxparam("stage","liststageconsult","marin");'>
                    <option value ='0' >S&eacute;lectionner le stage</option>
                    @foreach($stages as $stageexistant)
                    <option value ='{{$stageexistant->id}}'>{{$stageexistant->stage_libcourt}}</option>
                    @endforeach
                </select>
            </div>
            <div class='form-group row w-50 mt-3' style='margin-left:50%;'>
                <label for='listmarins' class='col-sm-5 col-form-label'> Marin </label>
                <select name='listmarins' id='listmarins' class='custom-select  w-50' onchange='modifdeuxparam("marin","listmarins","stage");'>
                    <option value ='0' >S&eacute;lectionner le marin</option>
                    @foreach($users as $userexistant)
                    <option value ='{{$userexistant->id}}' >{{$userexistant->displayString()}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($marin == null)
        <div
                class='card border-primary mb-3 w-50'>
                <div class='card-header text-primary'>Liste des marins ayant valid&eacute; le stage {{$stage->stage_libcourt}}</div>
                <div class='card-body'>
                    <table class='table-hover' style='width:100%;'>
                        <tr style='background-color:#DCDCDC; font-weight: bold;'>
                            <td style='height:40px;'>Grd</td>
                            <td>Bvt</td>
                            <td>Sp&eacute;</td>
                            <td>Nom</td>
                            <td>Pr&eacute;nom</td>
                            <td>Mat</td>
                            <td>Secteur</td>
                            <td>Date valid</td>
                        </tr>
                        @foreach($stage->users()->get() as $user)
                            @if ($user->pivot->date_validation != null)
                            <tr title='' style='color:black; '>
                                <td style='height:40px;'>{{$user->displayGrade()}}   </td>
                                <td>{{$user->displayDiplome()}} </td>
                                <td>{{$user->displaySpecialite()}} </td>
                                <td><a href='{{ route("stages.show", ["stage" => $stage->id, "marin" => $user->id]) }}'>{{$user->name}} </a></td>
                                <td>{{$user->prenom}} </td>
                                <td>{{$user->matricule}}</td>
                                <td>{{$user->displaySecteur()}} </td>
                                <td>{{$user->pivot->date_validation}}</td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
        </div>
        <div class='card border-primary mb-3 w-50'>
            <div class='card-header text-primary'>Liste des marins en attente du stage {{$stage->stage_libcourt}}</div>
            <div class='card-body'>
                <table class='table-hover' style='width:100%;'>
                    <tr style='background-color:#DCDCDC; font-weight: bold;'>
                        <td style='height:40px;'>Grd</td>
                        <td>Bvt</td>
                        <td>Sp&eacute;</td>
                        <td>Nom</td>
                        <td>Pr&eacute;nom</td>
                        <td>Mat</td>
                        <td>Secteur</td>
                        <td>Dest</td>
                        <td>Date mut</td>
                    </tr>
                    @foreach($stage->users()->get() as $user)
                        @if ($user->pivot->date_validation == null)
                        <tr title='' style='color:black; '>
                    
                            <td style='height:40px;'>{{$user->displayGrade()}} </td>
                            <td>{{$user->displayDiplome()}} </td>
                            <td>{{$user->displaySpecialite()}} </td>
                            <td><a href='{{ route("stages.show", ["stage" => $stage->id, "marin" => $user->id]) }}'>{{$user->name}} </a></td>
                            <td>{{$user->prenom}} </td>
                            <td>{{$user->matricule}}</td>
                            <td>{{$user->displaySecteur()}} </td>
                            <td>{{$user->displayDestination()}}</td>
                            <td>{{$user->displayDateDebarquement()}}</td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        @else
        <div class='mt-2 mb-2' style='margin-left:50%; text-align: center;'> </div>
        <div class='mt-2 mb-2' style='margin-left:50%; text-align: center;'> </div>
        <div class='card border-primary mb-3 w-50' style='margin-left:50%;'>
            <div class='card-header text-primary'>Liste des stages valid&eacute;s pour {{$marin->displayString()}}</div>
            <div class='card-body'>
                @foreach ($marin->stages()->get() as $stageenattente)
                @if ($stageenattente->pivot->date_validation != null)
                <div class='mt-3'><a href='{{route("stages.show", $stageenattente->id)}}'>{{ $stageenattente->stage_libcourt }}</a></div>
                @endif
                @endforeach
            </div>
        </div>
        <div class='card border-primary mb-3 w-50' style='margin-left:50%;'>
            <div class='card-header text-primary'>Liste des stages en attente pour le {{$marin->displayString()}}</div>
            <div class='card-body'>
                @foreach ($marin->stages()->get() as $stageenattente)
                @if ($stageenattente->pivot->date_validation == null)
                <div class='mt-3'><a href='{{route("stages.show", $stageenattente->id)}}'>{{ $stageenattente->stage_libcourt }}</a></div>
                @endif
                @endforeach
            </div>
        </div>
        @endif
        
        
        
        
    </div>
    

@endsection