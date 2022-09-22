@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Statistiques</h2>

        <div class='flex' style='justify-content: start;'>
            <nav class='navbar-brand bg-light border' style='width: 15rem; height: auto; flex-direction: column; justify-content: start ;'>
                <div class='titrenavbarvert'>Statistiques</div>
                <div class='mb-2 ml-2 mt-2 mr-2'>
                    <select name='listdates' id='listdates' class='custom-select w-100' onchange='modifparam("period","listdates");'>
                    @foreach ($liste_des_periodes as $per)
                        <option value ='{{$per}}'>{{$per}}</option>
                     @endforeach
                    </select>
                </div>
                <form
                    method='post' action='#'>
                    <div class='mb-2 mt-2 text-center'><button class='btn btn-primary' type='submit' id='btnstat' name='btnstat'>Calculer</button></div>
                    </form>
                    <div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='affichage("indic");annuler("durspe");annuler("durmarin");annuler("durgtr");'>Indicateurs</a></div>
                    <div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='annuler("indic");annuler("durspe");affichage("durmarin");annuler("durgtr");'>Temps de l&acirc;cher (marin)</a></div>
                    <hr>
                    <div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='annuler("indic");affichage("durspe");annuler("durmarin");annuler("durgtr");'>Temps de l&acirc;cher (sp&eacute;)</a></div>
                    <!--<div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='annuler("indic");annuler("durspe");annuler("durmarin");affichage("durgtr");'>Temps de l&acirc;cher (gtr)</a></div> -->
            </nav>
            <div id='indic' class='card bg-light ml-3 w-50' style=''>
                <div class='card-header'>Indicateurs 2PS (marin d&eacute;barquant vers une FREMM) </div>
                <div id='div2ps' class='mb-2 ml-2 mt-2 mr-2'>
                    <table class='table table-hover'>
                        <tr>
                            <td>Nb marins</td>
                            <td class='w-25'>{{$statistiques->count()}}</td>
                        </tr>
                        <tr>
                            <td>Taux SAE achev&eacute;</td>
                            <td>{{$statistiques->avg('taux_stage_valides')}}%</td>
                        </tr>
                        <tr>
                            <td>Taux compagnonnage achev&eacute;</td>
                            <td>{{$statistiques->avg('taux_comp_valides')}}%</td>
                        </tr>
                        <tr>
                            <td>Taux transformation</td>
                            <td>{{$statistiques->avg('taux_de_transformation')}}%</td>
                        </tr>
                        <tr>
                            <td>Nb jours au GTR</td>
                            <td>{{$statistiques->avg('nb_jour_gtr')}}</td>
                        </tr>
                    </table>
                </div>
                <div class='card-header'>Indicateurs OPS </div>
                <div id='divops' class='mb-2 ml-2 mt-2 mr-2'>
                    <table class='table table-hover'>
                        <tr title=''>
                            <td>Nb de marins</td>
                            <td class='w-25'>{{$statistiques->where('gpmt', 'OPS')->count()}}</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s quai</td>
                            <td>{{ $statistiques
                                    ->where('gpmt', 'OPS')
                                    ->where('nb_jour_pour_lache_quai', '>', 0)
                                    ->count() }}</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s mer</td>
                            <td>{{ $statistiques
                                       ->where('gpmt', 'OPS')
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
                        </tr>
                    </table>
                </div>
                <div class='card-header'>Indicateurs NAV </div>
                <div id='divnav' class='mb-2 ml-2 mt-2 mr-2'>
                    <table class='table table-hover'>
                        <tr title=''>
                            <td>Nb de marins</td>
                            <td class='w-25'>{{$statistiques->where('gpmt', 'NAV')->count()}}</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s quai</td>
                            <td>{{ $statistiques
                                    ->where('gpmt', 'NAV')
                                    ->where('nb_jour_pour_lache_quai', '>', 0)
                                    ->count() }}</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s mer</td>
                            <td>{{ $statistiques
                                       ->where('gpmt', 'NAV')
                                       ->where('nb_jour_pour_lache_mer', '>', 0)
                                       ->count() }}</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s quai+mer</td>
                            <td>{{ $statistiques
                                        ->where('gpmt', 'NAV')
                                        ->where('nb_jour_pour_lache_quai', '>', 0)
                                        ->where('nb_jour_pour_lache_mer', '>', 0)
                                        ->count()}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id='durmarin' class='card bg-light ml-3 w-100' style='display:none;'>
                <div class='card-header'>Dur&eacute;e moyenne avant l&acirc;cher par marin</div>
                <table class='table table-hover'>
                    <tr>
                        <td>Service</td>
                        <td>Grade</td>
                        <td>Brevet</td>
                        <td>Sp&eacute;cialit&eacute;</td>
                        <td>Nom</td>
                        <td>Pr&eacute;nom</td>
                        <td>Fonction quai</td>
                        <td>Fonction mer</td>
                        <td>Pr&eacute;sence</td>
                        <td>Date d&eacute;b.</td>
                    </tr>
                    @foreach ($statistiques as $stat)
                    <tr>
                        <td>{{$stat->service}}</td>
                        <td>{{$stat->grade}}</td>
                        <td>{{$stat->diplome}}</td>
                        <td>{{$stat->specialite}}</td>
                        <td>{{$stat->name}}</td>
                        <td>{{$stat->prenom}}</td>
                        <td>{{$stat->nb_jour_pour_lache_quai}}</td>
                        <td>{{$stat->nb_jour_pour_lache_mer}}</td>
                        <td>{{$stat->nb_jour_gtr}}</td>
                        <td>{{$stat->date_debarq}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div id='durspe' class='card bg-light ml-3 w-50' style='display:none;'>
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
            <div id='durgtr' class='card bg-light ml-3 w-50' style='display:none;'>
                <div class='card-header'>Dur&eacute;e moyenne (jour) avant l&acirc;cher par brevet/sp&eacute;cialit&eacute; </div>
                <table class='table table-hover'>
                    <tr>
                        <td>Brevet</td>
                        <td>Sp&eacute;cialit&eacute;</td>
                        <td>Fonction quai</td>
                        <td>Fonction mer</td>
                        <td>Pr&eacute;sence</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
@endsection