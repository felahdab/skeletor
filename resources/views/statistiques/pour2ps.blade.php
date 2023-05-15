@extends('layouts.app-master')

@section('helplink')
< x-help-link page="statistiques"/>
@endsection


@section('content')
        <div class='flex row mt-4'>
            <div class="col" style='background-color: transparent;'>
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
                                    @php
                                        $nb_user_a_valider=$stage->users()->wherePivotNull('date_validation')->get()->count();
                                    @endphp
                                    @if($nb_user_a_valider != 0)
                                    <tr>
                                        <td>{{$stage->stage_libcourt}}</td>
                                        <td>{{$nb_user_a_valider}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col" style='background-color: transparent;'>
                <div style='width:80%; border: 1px solid darkgrey'>
                    <p class='card-header border' style='height: 48px; text-align:center;'> STAGES EXT&Eacute;RIEURS</p>
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
                                    @php
                                        $nb_user_a_valider=$stage->users()->wherePivotNull('date_validation')->get()->count();
                                    @endphp
                                    @if($nb_user_a_valider != 0)
                                    <tr>
                                        <td>{{$stage->stage_libcourt}}</td>
                                        <td>{{$nb_user_a_valider}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection