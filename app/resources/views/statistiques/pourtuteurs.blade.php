@extends('layouts.app-master')

@section('content')
        <div class='flex'>
            <div style='width: 100%; background-color: transparent;'>
                <div style=' width:100%; border: 1px solid darkgrey'>
                    <p class='card-header border' style='height: 48px;'> SUIVI TRANSFORMATION : {{ $currentuser->displayService()}}</p>
                    <div>
                        <table class='table table-hover'>
                            <thead style='position: sticky; top: 0; background: lightgray; border: 1px solid #C3C3C3;'>
                                <tr>
                                    <th>Marin</th>
                                    <th>Service/Secteur</th>
                                    <th>Spécialité</th>
                                    <th>Fonction quai</th>
                                    <th>Fonction mer</th>
                                    <th>Fonction métier</th>
                                    <th>Taux transfo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $marin)
                                <tr title=''>
                                    <td><a href ="{{ route('transformation.livret', $marin->id) }}">{{$marin->displayString()}}</a></td>
                                    <td>{{$marin->displayServiceSecteur()}}</td>
                                    <td>{{$marin->displayDiplome() . " " . $marin->displaySpecialite()}}</td>
                                    @php
                                       $fonctionAQuai = $marin->fonctionAQuai();
                                    @endphp
                                    <td style='@if($fonctionAQuai != null){!! $marin->getFonctionHtmlAttribute($fonctionAQuai) !!}@else'@endif
                                    </td>
                                    @php
                                       $fonctionAMer = $marin->fonctionAMer();
                                    @endphp
                                    <td style='@if($fonctionAMer != null){!! $marin->getFonctionHtmlAttribute($fonctionAMer) !!}@else'@endif
                                    </td>
                                    <td>
                                        <ul style='list-style-type : none;'>
                                        @php
                                        $fonctionsMetier = $marin->fonctionsMetier()->get();
                                        @endphp
                                            @foreach($fonctionsMetier as $fonction)
                                            <li style='margin-bottom: 3px;{!! $marin->getFonctionHtmlAttribute($fonction) !!}</li>
                                            @endforeach
                                        </ul>
                                        <td>{{substr($marin->taux_de_transformation, 0, 4)}}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection