@extends('layouts.app-master')

@section('helplink')
< x-help-link page="statistiques"/>
@endsection

@section('content')

        <div class='flex row mt-4'>
            <div class="col" style='background-color: transparent;'>
                <div class='ml-4' style='width:100%;'>
                      <div style="display: flex; align-items: center; height: 48px; justify-content: center; border-bottom: 0!important" class="border">
                      <p class='card-header'> STAGES SOUS LICENCE</p>
                      </div>
                    <div>
                        <table class='table table-hover table-bordered'>
                            <thead>
                                <tr style='background-color:silver;'>
                                    <th class="align-middle" style='width: 50%; '>Libell&eacute;</th>
                                    <th class="align-middle text-center" >Nb marins &agrave; valider</th>
                                    <th class="align-middle text-center" >Nb marins validés</th>
                                    <th class="align-middle text-center" >Taux &agrave; valider (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stagelics as $stagelic)
                                    <tr>
                                        <td><a href="{{ route('transformation::stages.show', $stagelic['idstage']) }}">{{$stagelic['libstage']}}</a></td>
                                        <td class="text-end">{{$stagelic['nbmarinsavalider']}}</td>
                                        <td class="text-end">{{$stagelic['nbmarinsvalides']}}</td>
                                        <td class="text-end">{{$stagelic['taux']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col" style='background-color: transparent;'>
                <div style='width:100%; '>
                    <div style="display: flex; align-items: center; height: 48px; justify-content: center; border-bottom: 0!important" class="border">
                        <p class='card-header'> STAGES EXT&Eacute;RIEURS</p>
                    </div>
                    <div>
                        <table class='table table-hover table-bordered'>
                            <thead>
                                <tr style='background-color:silver;'>
                                    <th class="align-middle" style='width: 50%; '>Libell&eacute;</th>
                                    <th class="align-middle text-center" >Nb marins &agrave; valider</th>
                                    <th class="align-middle text-center" >Nb marins validés</th>
                                    <th class="align-middle text-center" >Taux &agrave; valider (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stageexts as $stageext)
                                    <tr>
                                        <td><a href="{{ route('transformation::stages.show', $stageext['idstage']) }}">{{$stageext['libstage']}}</a></td>
                                        <td class="text-end">{{$stageext['nbmarinsavalider']}}</td>
                                        <td class="text-end">{{$stageext['nbmarinsvalides']}}</td>
                                        <td class="text-end">{{$stageext['taux']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection


