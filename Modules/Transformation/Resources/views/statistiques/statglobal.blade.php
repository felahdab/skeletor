@extends('layouts.app-master')

@section('helplink')
< x-help-link page="statistiques"/>
@endsection


@section('content')
        <div style='text-align: center;margin-top: 25px;margin-bottom: 25px;'>
            <h1>Nb total de marins en transformation : {{$users->where("en_transformation", true)->count()}}</h1>
        </div>
        <div class='flex row'>
            <div class="col" style='background-color: transparent;'>
                <table class='table table-hover' style='width:80%;'>
                    <tr style='background-color:lightgray;'>
                        <th style='width:80%;'>Service</th>
                        <th>Nb transfo</th>
                    </tr>
                    @foreach($services as $service)
                    
                    <tr>
                        <td><a href="{{route ('transformation::statistiques.parservice', $service ) }}">{{$service->service_libcourt}}</a></td>
                        <td>@php
                                $service_id = $service->id;
                                $serviceusers = $users->where('secteur.service_id', $service_id);
                                $activeusers = $serviceusers->where('en_transformation', true); 
                            @endphp
                            {{$activeusers->count()}}
                        </td>
                    </tr>
                    
                    @endforeach
                </table>
            </div>
            <div class="col" style='width: 50%; background-color: transparent;'>
                <table class='table table-hover' style='width:80%;'>
                    <tr style='background-color:lightgray;'>
                        <th style='width:80%;'>Fonction quai</th>
                        <th>Nb transfo</th>
                        <th>Nb lâché</th>
                    </tr>
                    @foreach($fonctionsaquai->get() as $fonction)
                        <tr>
                            <td><a dusk="listemarins-fct-lien-{{$loop->index}}" href="{{route ('transformation::fonctions.listemarinsfonction', $fonction->id ) }}">{{$fonction->fonction_libcourt}}</a></td>
                            <td>{{$fonction->users()->count()}}</td>
                            <td>{{$fonction->users()->get()->whereNotNull('pivot.date_lache')->count()}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
@endsection