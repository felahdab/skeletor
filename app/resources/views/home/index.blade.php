@extends('layouts.app-master')

@section('content')
    @guest
    <div>
        <img src='{!! url("assets/images/InsigneEscouade.jpg") !!}' alt="Logo de l'escouade" style="height:450px; display: block; margin-left:auto; margin-right: auto; ">
    </div>
    @endguest
    
    @auth
    @if(auth()->user()->hasRole("2ps"))
        <div class='flex'>
            <div style='width: 50%; background-color: transparent;'>
                <div class='ml-4' style='width:80%; border: 1px solid darkgrey'>
                    <p class='card-header border' style='height: 48px; text-align:center;'> STAGES SOUS LICENCE</p>
                    <div>
                        <table class='table table-hover'>
                            <thead>
                                <tr style='background-color:rgba(0, 0, 0, 0.03);'>
                                    <th style='width: 80%; vertical-align:middle;'>Libell&eacute;</th>
                                    <th style='vertical-align:middle;'>Nb marins &agrave;<br>valider</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stages->where('typelicence_id', '<', 4) as $stage)
                                    @if($stage->users()->get()->whereNull('pivot_date_validation')->count() != 0)
                                    <tr>
                                        <td>{{$stage->stage_libcourt}}</td>
                                        <td>{{$stage->users()->get()->whereNull('pivot_date_validation')->count()}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style='width: 50%; background-color: transparent;'>
                <div style='width:80%; border: 1px solid darkgrey'>
                    <p class='card-header border' style='height: 48px;'> STAGES EXT&Eacute;RIEURS</p>
                    <div>
                        <table class='table table-hover'>
                            <thead>
                                <tr style='background-color:rgba(0, 0, 0, 0.03);'>
                                    <th style='width: 80%; vertical-align:middle;'>Libell&eacute;</th>
                                    <th style='vertical-align:middle;'>Nb marins &agrave;<br>valider</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stages->where('typelicence_id', 4) as $stage)
                                    @if($stage->users()->get()->whereNull('pivot_date_validation')->count() != 0)
                                    <tr>
                                        <td>{{$stage->stage_libcourt}}</td>
                                        <td>{{$stage->users()->get()->whereNull('pivot_date_validation')->count()}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->hasRole("tuteur"))
        <div class='flex'>
            <div style='width: 100%; background-color: transparent;'>
                <div style=' width:100%; border: 1px solid darkgrey'>
                    <p class='card-header border' style='height: 48px;'> SUIVI TRANSFORMATION : {{auth()->user()->displaySecteur()}}</p>
                    <div>
                        <table class='table table-hover'>
                            <thead style='position: sticky; top: 0; background: lightgray; border: 1px solid #C3C3C3;'>
                                <tr>
                                    <th>Marin</th>
                                    <th>Spécialité</th>
                                    <th>Fonction quai</th>
                                    <th>Fonction mer</th>
                                    <th>Fonction métier</th>
                                    <th>Taux transfo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users->where('secteur_id', auth()->user()->secteur_id) as $marin)
                                <tr title='{{$marin->matricule}}'>
                                    <td>{{$marin->displayString()}}</td>
                                    <td>{{$marin->displayDiplome() . " " . $marin->displaySpecialite()}}</td>
                                    <td style='@if($marin->fonctionAQuai() != null){!! $marin->getFonctionHtmlAttribute($marin->fonctionAQuai()) !!}@else'@endif
                                    </td>
                                    <td style='@if($marin->fonctionAMer() != null){!! $marin->getFonctionHtmlAttribute($marin->fonctionAMer()) !!}@else'@endif
                                    </td>
                                    <td>
                                        <ul style='list-style-type : none;'>
                                            @foreach($marin->fonctionsMetier()->get() as $fonction)
                                            <li style='margin-bottom: 3px;{!! $marin->getFonctionHtmlAttribute($fonction) !!}</li>
                                            @endforeach
                                        </ul>
                                        <td>{{substr($marin->taux_de_transformation(), 0, 4)}}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->hasRole("em"))
        <div style='text-align: center;margin-top: 25px;margin-bottom: 25px;'>
            <h1>Nb total de marins en transformation : 8</h1>
        </div>
        <div class='flex'>
            <div style='width: 50%; background-color: transparent;'>
                <table class='table table-hover' style='width:80%;'>
                    <tr style='background-color:lightgray;'>
                        <th style='width:80%;'>Service</th>
                        <th>Nb transfo</th>
                    </tr>
                    <tr>
                        <td>ARM</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>CMA</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>ELEC SECU</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>EM</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>LAS</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>LSM AVIA</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>MACH FLOT</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>PONT</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>SANTE</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>SIC</td>
                        <td>0</td>
                    </tr>
                </table>
            </div>
            <div style='width: 50%; background-color: transparent;'>
                <table class='table table-hover' style='width:80%;'>
                    <tr style='background-color:lightgray;'>
                        <th style='width:80%;'>Fonction quai</th>
                        <th>Nb transfo</th>
                    </tr>
                    <tr title=''>
                        <td>GRADE CMA</td>
                        <td>0</td>
                    </tr>
                    <tr title='SM LASAPP Renant 15%&#10;MOT PENNETIER Clement 0%&#10;'>
                        <td>GRADE COUPEE</td>
                        <td>2</td>
                    </tr>
                    <tr title=''>
                        <td>GRADE ELEC</td>
                        <td>0</td>
                    </tr>
                    <tr title='SM MACHAPP Renant 1%&#10;MT SZA Admin 0%&#10;'>
                        <td>GRADE NAVIRE</td>
                        <td>2</td>
                    </tr>
                    <tr title=''>
                        <td>GRADE PONT</td>
                        <td>0</td>
                    </tr>
                    <tr title=''>
                        <td>GRADE SIC</td>
                        <td>0</td>
                    </tr>
                    <tr title='LV ETAT Major 20%&#10;PM TUT Las 0%&#10;PM TUT Mach 0%&#10;'>
                        <td>OG</td>
                        <td>3</td>
                    </tr>
                    <tr title=''>
                        <td>OPN</td>
                        <td>0</td>
                    </tr>
                    <tr title=''>
                        <td>OPSC</td>
                        <td>0</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    @endauth
@endsection