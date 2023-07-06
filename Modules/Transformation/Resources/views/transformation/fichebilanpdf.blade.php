<style type='text/css'>
    .tableacueil{
        text-align: center;
        width: 210mm;
        color: #737175;    
    }
    .datedit{
        text-align:right;
        font-size:8pt;
        height:15mm;
    }
    .nom{
        height:30mm;
        font-size:25pt;
        color:black;
    }
    .tablerecap{
        width: 210mm;
        color: #737175;
    }
    .titrerecap
    {
        font-size:25pt;
        color:black;
        text-align: center;
    }
    .tabcompstage{
        width : 100% ;
        border-collapse: collapse;
        border: solid 1px black
    }
    .h-20{height:20mm;}
    .titrecompstage{background-color:whitesmoke;}
    .colcompstage{border-right: solid;}
    .bt{border-top: solid 1px black;}
    .bb{border-bottom: solid 1px black;}
    .bl{border-left: solid 1px black;}
    .br{border-right: solid 1px black;}
    .w-25{width: 25%;}
    .w-50{width: 50%;}
    .w-75{width: 75%;}
    .w-100{width: 100%;}

</style>

<page>
    <table class='tableacueil '>
        <tr>
            <td>&nbsp;</td>
            <td class='datedit'>&Eacute;dit&eacute; le : {{date('Y-m-d') }}</td>
        </tr>
        <tr>
            <td colspan='2' class='titrerecap'>FICHE BILAN<br><br>{{$user->display_name}}<br></td>
        </tr>
        <tr class='h-20'>
            <td colspan='2'><br></td>
        </tr>
        <tr class='h-20'>
            <td>Sp&eacute;cialit&eacute; : {{ $user->displaySpecialite() }}</td>
            <td>Service/Secteur : {{$user->displayServiceSecteur()}}</td>
        </tr>
        <tr class='h-20'>
            <td>Date embarquement : {{$user->date_embarq}}</td>
            <td>Brevet : {{$user->displayDiplome()}} </td>
        </tr>
    </table>
<div class="h-20">&nbsp;</div>
    <table class='tablerecap'>
        <tr><td class='titrerecap' colspan="3">Taux de transformation</td></tr>
        <tr>
            <td>
            <table class='tabcompstage'>
                <tr>
                    <th class='titrecompstage w-50 colcompstage'>Fonction</th>
                    <th class='titrecompstage w-25 colcompstage'>Taux</th>
                    <th class='titrecompstage w-25 colcompstage'>Date de lâché</th>
                </tr>
                @foreach ($user->fonctions()->get() as $fonction)
                    <tr>
                        <td class='colcompstage br bl bt bb'>{{ $fonction->fonction_liblong}}</td>
                        <td class='colcompstage br bl bt bb'>{{ $fonction->pivot->taux_de_transformation}}</td>
                        <td class='colcompstage br bl bt bb'>{{ $fonction->pivot->date_lache == null ? "" : $fonction->pivot->date_lache }}</td>
                    </tr>
                @endforeach
            </table>
            </td>
        </tr>
    </table>
<pagebreak>
    <table class='tablerecap w-100'>
        <tr><td class='titrerecap' colspan="2">Situation des compagnonnages</td></tr>
        <tr>
            <td class='w-100'>
                <table class='tabcompstage w-100'>
                    <tr>
                        <th class='titrecompstage w-75 colcompstage'>Compagnonnage</th>
                        <th class='titrecompstage w-25 colcompstage'>Taux</th>
                    </tr>
                    @foreach ($user->fonctions()->get() as $fonction)
                        @foreach ($fonction->compagnonages()->get() as $comp)
                            <tr>
                                <td class='colcompstage br bl bt bb'>{{ $comp->comp_libcourt}}</td>
                                <td class='colcompstage br bl bt bb'>{{ $user->getTransformationManager()->taux_de_transformation(null, $comp, null, null)}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
<pagebreak>
        <table class='tablerecap'>
        <tr><td class='titrerecap' colspan="3">Situation des stages</td></tr>
        <tr>
            <td>
            <table class='tabcompstage'>
                <tr>
                    <th class='titrecompstage w-50 colcompstage'>Stage</td>
                    <th class='titrecompstage w-25 colcompstage'>Etat de validation</td>
                    <th class='titrecompstage w-25 colcompstage'>Date de validation</td>
                </tr>
                @foreach ($user->stages()->get() as $stage)
                    <tr>
                        <td class='colcompstage br bl bt bb'>{{ $stage->stage_libcourt}}</td>
                        <td class='colcompstage br bl bt bb'>{{ $stage->pivot->date_validation == null ? "NON VALIDE" : "VALIDE" }}</td>
                        <td class='colcompstage br bl bt bb'>{{ $stage->pivot->date_validation == null ? "" : $stage->pivot->date_validation }}</td>
                    </tr>
                @endforeach
            </table>
            </td>
        </tr>
    </table>
</page>
