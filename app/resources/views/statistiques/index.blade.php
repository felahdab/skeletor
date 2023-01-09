@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="statistiques"/>
@endsection


@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Indicateurs</h2>
        <div class='mb-2 mt-2 me-2 w-25'>
            <select name='listdates' id='listdates' class='custom-select w-100' onchange='modifparam("period","listdates");'>
                <option value ='à choisir'>Choisissez la période</option>
            @foreach ($liste_des_periodes as $per)
                <option value ='{{$per}}'>{{$per}}</option>
             @endforeach
            </select>
        </div>
        <div class="lead mt-3">
            <form method='post' action='#'>
                Période sélectionnée : {{$period}} <a class='btn btn-success btn-sm ml-2' href="{{ route('statistiques.index', ['period' =>$period, 'calcul' =>$period] ) }}" id='btnstat' name='btnstat'>Recalculer cette période</a>
            </form>
        </div>
    </div>
    <div class='ms-4'>
        <a class='btn btn-secondary btn-sm' href='#' onclick='affichage("indic");annuler("durspe");annuler("durmarin");'>Indicateurs</a>
        <a class='btn btn-primary btn-sm' href='#' onclick='annuler("indic");annuler("durspe");affichage("durmarin");'>Temps de l&acirc;cher par marin</a>
        <a class='btn btn-info btn-sm' href='#' onclick='annuler("indic");affichage("durspe");annuler("durmarin");'>Temps de l&acirc;cher par sp&eacute;</a>
    </div>
    <div class='flex' style='justify-content: start;'>
        <div id='indic' class='card bg-light w-100' style=''>
            <div>
                <table class='table table-hover'>
                    <tr class='card-header'>
                        <td>Indicateurs</td>
                        <td>OPS</td>
                        <td>NAV</td>
                        <td>Global</td>
                    </tr>

                    <tr>
                        <td>Nb marins</td>
                        <td>{{$statistiques->where('gpmt', 'OPS')->count()}}</td>
                        <td>{{$statistiques->where('gpmt', 'NAV')->count()}}</td>
                        <td>{{$statistiques->count()}}</td>
                    </tr>
                    <tr>
                        <td>Taux SAE achev&eacute;</td>
                        <td>{{round($statistiques->where('gpmt', 'OPS')->avg('taux_stage_valides'),2)}}%</td>
                        <td>{{round($statistiques->where('gpmt', 'NAV')->avg('taux_stage_valides'),2)}}%</td>
                        <td>{{round($statistiques->avg('taux_stage_valides'),2)}}%</td>
                    </tr>
                    <tr>
                        <td>Taux compagnonnage achev&eacute;</td>
                        <td>{{round($statistiques->where('gpmt', 'OPS')->avg('taux_comp_valides'),2)}}%</td>
                        <td>{{round($statistiques->where('gpmt', 'NAV')->avg('taux_comp_valides'),2)}}%</td>
                        <td>{{round($statistiques->avg('taux_comp_valides'),2)}}%</td>
                    </tr>
                    <tr>
                        <td>Taux transformation</td>
                        <td>{{round($statistiques->where('gpmt', 'OPS')->avg('taux_de_transformation'),2)}}%</td>
                        <td>{{round($statistiques->where('gpmt', 'NAV')->avg('taux_de_transformation'),2)}}%</td>
                        <td>{{round($statistiques->avg('taux_de_transformation'),2)}}%</td>
                    </tr>
                    <tr>
                        <td>Nb jours au GTR</td>
                        <td>{{round($statistiques->where('gpmt', 'OPS')->avg('nb_jour_gtr'),0)}}</td>
                        <td>{{round($statistiques->where('gpmt', 'NAV')->avg('nb_jour_gtr'),0)}}</td>
                        <td>{{round($statistiques->avg('nb_jour_gtr'),0)}}</td>
                    </tr>
                    <tr>
                        <td>Nb marins l&acirc;ch&eacute;s quai</td>
                        <td>{{ $statistiques
                                ->where('gpmt', 'OPS')
                                ->where('nb_jour_pour_lache_quai', '>', 0)
                                ->count() }}</td>
                        <td>{{ $statistiques
                                ->where('gpmt', 'NAV')
                                ->where('nb_jour_pour_lache_quai', '>', 0)
                                ->count() }}</td>
                        <td>{{ $statistiques
                                ->where('nb_jour_pour_lache_quai', '>', 0)
                                ->count() }}</td>
                    </tr>
                    <tr>
                        <td>Nb marins l&acirc;ch&eacute;s mer</td>
                        <td>{{ $statistiques
                                   ->where('gpmt', 'OPS')
                                   ->where('nb_jour_pour_lache_mer', '>', 0)
                                   ->count() }}</td>
                        <td>{{ $statistiques
                                   ->where('gpmt', 'NAV')
                                   ->where('nb_jour_pour_lache_mer', '>', 0)
                                   ->count() }}</td>
                        <td>{{ $statistiques
                                   ->where('nb_jour_pour_lache_mer', '>', 0)
                                   ->count() }}</td>
                    </tr>
                    <tr>
                        <td>Nb marins l&acirc;ch&eacute;s quai+mer</td>
                        <td>{{ $statistiques
                                    ->where('gpmt', 'OPS')
                                    ->where('nb_jour_pour_lache_quai', '>', 0)
                                    ->where('nb_jour_pour_lache_mer', '>', 0)
                                    ->count()}}</td>
                        <td>{{ $statistiques
                                    ->where('gpmt', 'NAV')
                                    ->where('nb_jour_pour_lache_quai', '>', 0)
                                    ->where('nb_jour_pour_lache_mer', '>', 0)
                                    ->count()}}</td>
                        <td>{{ $statistiques
                                    ->where('nb_jour_pour_lache_quai', '>', 0)
                                    ->where('nb_jour_pour_lache_mer', '>', 0)
                                    ->count()}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id='durmarin' class='card bg-light w-100' style='display:none;'>
            <div class='card-header'>Dur&eacute;e moyenne (jour) avant l&acirc;cher par marin </div>
            <div class="mt-3">
                <livewire:statistique-table period="{{$period}}">
            </div>
        </div>
        <div id='durspe' class='card bg-light w-50' style='display:none;'>
            <div class='card-header'>Dur&eacute;e moyenne (jour) avant l&acirc;cher par brevet/sp&eacute;cialit&eacute; </div>
            <table class='table table-hover'>
                <tr>
                    <td>Brevet</td>
                    <td>Sp&eacute;cialit&eacute;</td>
                    <td>Fonction quai</td>
                    <td>Fonction mer</td>
                    <td>Pr&eacute;sence</td>
                </tr>
                @foreach($statistiques->pluck('diplome', 'specialite')->unique() as $spe => $brevet)
                <tr>
                    <td>{{$brevet}}</td>
                    <td>{{$spe}}</td>
                    <td>{{$statistiques
                                ->where('specialite', $spe)
                                ->where('diplome', $brevet)
                                ->avg('nb_jour_pour_lache_quai')}}</td>
                    <td>{{$statistiques
                                ->where('specialite', $spe)
                                ->where('diplome', $brevet)
                                ->avg('nb_jour_pour_lache_mer')}}</td>
                    <td>{{$statistiques
                                ->where('specialite', $spe)
                                ->where('diplome', $brevet)
                                ->avg('nb_jour_gtr')}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection