@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Statistiques</h1>
        <div class="lead">
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <div class='flex' style='justify-content: start;'>
            <nav class='navbar-brand bg-light border' style='width: 15rem; height: auto; flex-direction: column; justify-content: start ;'>
                <div class='titrenavbarvert'>Statistiques</div>
                <div class='mb-2 ml-2 mt-2 mr-2'><select name='listdates' id='listdates' class='custom-select w-100' onchange='modifparam("month","listdates");'><option value ='2022-07-05' >juillet 2022</option><option value ='2022-06-05' >juin 2022</option><option value ='2022-05-05' >mai 2022</option><option value ='2022-04-05' >avril 2022</option><option value ='2022-03-05' >mars 2022</option><option value ='2022-02-05' >février 2022</option><option value ='2022-01-05' >janvier 2022</option><option value ='2021-12-05' >décembre 2021</option><option value ='2021-11-05' >novembre 2021</option><option value ='2021-10-05' >octobre 2021</option><option value ='2021-09-05' >septembre 2021</option><option value ='2021-08-05' >août 2021</option></select></div>
                <form
                    method='post' action='#'>
                    <div class='mb-2 mt-2 text-center'><button class='btn btn-primary' type='submit' id='btnstat' name='btnstat'>Calculer</button></div>
                    </form>
                    <div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='affichage("indic");annuler("durspe");annuler("durmarin");annuler("durgtr");'>Indicateurs</a></div>
                    <div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='annuler("indic");annuler("durspe");affichage("durmarin");annuler("durgtr");'>Temps de l&acirc;cher (marin)</a></div>
                    <hr>
                    <div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='annuler("indic");affichage("durspe");annuler("durmarin");annuler("durgtr");'>Temps de l&acirc;cher (sp&eacute;)</a></div>
                    <div class='mb-2 ml-4'><a class='navbar-brand-sm text-secondary' href='#' onclick='annuler("indic");annuler("durspe");annuler("durmarin");affichage("durgtr");'>Temps de l&acirc;cher (gtr)</a></div>
            </nav>
            <div id='indic' class='card bg-light ml-3 w-50' style=''>
                <div class='card-header'>Indicateurs 2PS (marin d&eacute;barquant vers une FREMM) </div>
                <div id='div2ps' class='mb-2 ml-2 mt-2 mr-2'>
                    <table class='table table-hover'>
                        <tr>
                            <td>Nb marins</td>
                            <td class='w-25'>0</td>
                        </tr>
                        <tr>
                            <td>Taux SAE achev&eacute;</td>
                            <td>0%</td>
                        </tr>
                        <tr>
                            <td>Taux compagnonnage achev&eacute;</td>
                            <td>0%</td>
                        </tr>
                        <tr>
                            <td>Taux transformation</td>
                            <td>0%</td>
                        </tr>
                        <tr>
                            <td>Nb jours au GTR</td>
                            <td>0</td>
                        </tr>
                    </table>
                </div>
                <div class='card-header'>Indicateurs OPS </div>
                <div id='divops' class='mb-2 ml-2 mt-2 mr-2'>
                    <table class='table table-hover'>
                        <tr title=''>
                            <td>Nb de marins</td>
                            <td class='w-25'>0</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s quai</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s mer</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s quai+mer</td>
                            <td>0</td>
                        </tr>
                    </table>
                </div>
                <div class='card-header'>Indicateurs NAV </div>
                <div id='divnav' class='mb-2 ml-2 mt-2 mr-2'>
                    <table class='table table-hover'>
                        <tr title=''>
                            <td>Nb de marins</td>
                            <td class='w-25'>0</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s quai</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s mer</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Nb marins l&acirc;ch&eacute;s quai+mer</td>
                            <td>0</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id='durmarin' class='card bg-light ml-3 w-100' style='display:none;'>
                <div class='card-header'>Dur&eacute;e moyenne (jour) avant l&acirc;cher par marin</div>
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
                </table>
            </div>
            <div id='durspe' class='card bg-light ml-3 w-50' style='display:none;'>
                <div class='card-header'>Dur&eacute;e moyenne (jour) avant l&acirc;cher par brevet/sp&eacute;cialit&eacute; (du <b>2021-07-31</b> au <b>2022-07-31</b>)</div>
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
            <div id='durgtr' class='card bg-light ml-3 w-50' style='display:none;'>
                <div class='card-header'>Dur&eacute;e moyenne (jour) avant l&acirc;cher par brevet/sp&eacute;cialit&eacute; (du <b>2020-09-01</b> au <b>2022-08-29</b>)</div>
                <table class='table table-hover'>
                    <tr>
                        <td>Brevet</td>
                        <td>Sp&eacute;cialit&eacute;</td>
                        <td>Fonction quai</td>
                        <td>Fonction mer</td>
                        <td>Pr&eacute;sence</td>
                    </tr>
                    <tr>
                        <td>BS</td>
                        <td>DET</td>
                        <td>128</td>
                        <td>0</td>
                        <td>165</td>
                    </tr>
                    <tr>
                        <td>BAT</td>
                        <td>SITEL</td>
                        <td>0</td>
                        <td>0</td>
                        <td>65</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
@endsection