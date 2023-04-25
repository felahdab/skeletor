    <style type='text/css'>
        .tableacueil{
            text-align: center;
            width: 210mm;
            color: #737175;
        
        }
        .titrelivret{
            font-size : 40pt;
            height:30mm;
        }
        .nom{
            height:30mm;
            font-size:25pt;
            color:black;
        }
        .datedit{
            text-align:right;
            font-size:8pt;
            height:15mm;
        }
        /* table recapitulative page 2 */
        .tablerecap{
            text-align: center;
            width: 210mm;
            color: #737175;
        }
        .titrerecap
        {
            font-size:25pt;
            height:30mm;
            color:black;
        }
        .titrefonction{
            text-align: center;
            font-size:18pt;
            height:20mm;
            color : #0062cc;
        }
        .tabcompstage{
            width : 100% ;
            border-collapse: collapse;
            border: solid 1px black
        }
        .titrelach{
            background-color : #0062cc;
            color : white;
        }
        .titrecompstage{
            background-color:whitesmoke;
        }
        .colcompstage{
            border-right: solid;
        }
        /* tableau des compagnonnages d'une fonction */
        .tablecomp{
            text-align: center;
            width: 210mm;
            vertical-align: middle;
            border-collapse: collapse;
        }
        .tablecomp td, tr{
            font-size: 10pt;
        }
        .tdcomp{
            text-align: center;
            background-color : #0062cc;
            color : white;
            height:30px;
        }
        .trlache{
            background-color: whitesmoke;
        }
        /* hauteur de ligne*/
        .h-10{height:10mm;}
        .h-20{height:20mm;}
        .h-25{height:25mm;}
        .h-30{height:30mm;}
        .h-80{height:80mm;}
        .h-200{height:200mm;}
        .h-test{height:200mm;}
        /*font-size*/
        .fz-18{font-size:18pt;}
        /*align*/
        .ta-l{text-align:left;}
        .ta-r{text-align:right;}
        .va-t{vertical-align: top;}
        .va-b{vertical-align: bottom;}
        /*width*/
        .w-5{width: 5%;}
        .w-15{width: 15%;}
        .w-25{width: 25%;}
        .w-35{width: 35%;}
        .w-50{width: 50%;}
        /*bordures*/
        .4bords {
            border: solid 1px black;
        }
        .bt{border-top: solid 1px black;}
        .bb{border-bottom: solid 1px black;}
        .bl{border-left: solid 1px black;}
        .br{border-right: solid 1px black;}
        .tablenote{
            text-align: center;
            width: 210mm;
            height: 250mm;
            /*border-collapse: collapse;*/
        }
        .titrenote
        {
            font-size:25pt;
            height:30mm;
        }
        .notedate{
            width: 15%;
            border-right: solid;
            border-bottom: solid;
        }
        .notebat{
            width: 25%;
            border-right: solid;
            border-bottom: solid;
        }
        .notecomment{
            width: 60%;
            border-bottom: solid;
        }
        .br-1{
            border-right: solid;
        }
    </style>

@php
        use App\Models\TypeFonction;
        $fmerid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'mer')->get()->first()->id;
        $fquaiid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'quai')->get()->first()->id;
        $fmetierid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'metier')->get()->first()->id;
@endphp

<page>
    <bookmark content='Accueil' level='0' />
    <table class='tableacueil '>
        <tr>
            <td>&nbsp;</td>
            <td class='datedit'>&Eacute;dit&eacute; le  : {{date('Y-m-d') }}</td>
        </tr>
        <tr>
            <td class='h-80'><img src='{{$pathbrest}}' alt='logo gtr brest'></td>
            <td><img src='{{$pathtln}}' alt='logo gtr toulon'></td>
        </tr>
        <tr>
            <td colspan='2' class='titrelivret'>LIVRET DE<br>TRANSFORMATION</td>
        </tr>
        <tr>
            <td colspan='2' class='nom'>{{$user->display_name}}</td>
        </tr>
        <tr class='h-20'>
            <td>Sp&eacute;cialit&eacute; : {{ $user->displaySpecialite() }}</td>
            <td>Service/Secteur : {{$user->displayServiceSecteur()}}</td>
        </tr>
        <tr class='h-20'>
            <td>Date embarquement : {{$user->date_embarq}}</td>
            <td>Brevet : {{$user->displayDiplome()}} </td>
        </tr>
        @if ($user->fonctions()->where('typefonction_id', $fquaiid)->get()->count() != 0 )
        <tr>
            <td  class='ta-r va-b h-25 fz-18'>Fonction de service &agrave; quai : </td>
            <td class='ta-l va-b fz-18'>
                @foreach($user->fonctions()->where('typefonction_id', $fquaiid)->get() as $foncquai)
                    {{ $foncquai->fonction_libcourt }}
                @endforeach 
            </td>
        </tr>
        @endif
        @if ($user->fonctions()->where('typefonction_id', $fmerid)->get()->count() != 0 )
        <tr>
            <td class='ta-r va-t h-25 fz-18'>Fonction de service en mer : </td>
            <td class='ta-l va-t fz-18'>
                @foreach($user->fonctions()->where('typefonction_id', $fmerid)->get() as $foncmer)
                    {{$foncmer->fonction_libcourt}}<br>
                @endforeach 
            </td>
        </tr>
        @endif
        @if ($user->fonctions()->where('typefonction_id', $fmetierid)->get()->count() != 0 )
        <tr>
            <td class='ta-r va-t h-25 fz-18'>Fonction(s) m&eacute;tier : </td>
            <td class='ta-l va-t fz-18'>
                @foreach($user->fonctions()->where('typefonction_id', $fmetierid)->get() as $foncmet)
                    {{$foncmet->fonction_libcourt}}<br>
                @endforeach 
            </td>
        </tr>
        @endif
    </table>
<pagebreak>

<bookmark content='Récapitulatif parcours' level='0' />
    <table class='tablerecap '>
        <tr><td class='titrerecap'>R&eacute;capitulatif du parcours de transformation</td></tr>
        @foreach ($user->fonctions()->get() as $fonction)
            @php
            $listcomp=$fonction->compagnonages()->get()->pluck('comp_libcourt')->all();
            $liststage=$fonction->stages()->get()->pluck('stage_libcourt')->all();
            
            $nbcomp=count($listcomp);
            $nbstage=count($liststage);
            
            if ($nbcomp == $nbstage)
                ;
            elseif ($nbcomp > $nbstage)
            {
                $complement = array_fill(0, $nbcomp - $nbstage, '');
                $liststage = array_merge($liststage, $complement);
            }
            elseif ($nbcomp < $nbstage)
            {
                $complement = array_fill(0, $nbstage - $nbcomp, '');
                $listcomp = array_merge($listcomp, $complement);
            }
            
            @endphp
            <tr><td class='titrecompstage'>{{$fonction->fonction_libcourt}}</td></tr>
            <tr><td class='ta-c'>
                    <table class='tabcompstage'>
                        <tr>
                            <th class='titrecompstage w-50 colcompstage'>Compagnonnage(s)</th>
                            <th class='titrecompstage'>Stage(s)</th>
                        </tr>
                        @foreach($listcomp as $libcomp)
                            <tr>
                                <td class='colcompstage'>{{$libcomp}}</td>
                                <td>{{ $liststage[$loop->index] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            @php
                $liblach="";
                if ($fonction->fonction_double)
                {
                    $liblach.="DOUBLE + ";
                }
                if ($fonction->fonction_lache)
                {
                    $liblach.="LACHER";
                }
            @endphp
            @if ($liblach!="")
            <tr>
                <td class='titrelach'>{{$liblach}}</td>
            </tr>
            @endif
        @endforeach
</table>
<pagebreak>

<bookmark content='Stages' level='0' />
    <table class='tablerecap'>
        <tr><td class='titrerecap' colspan="3">Taux de transformation</td></tr>
        <tr>
            <td class='ta-c'>
            <table class='tabcompstage'>
                <tr>
                    <th class='titrecompstage w-50 colcompstage'>Fonction</td>
                    <th class='titrecompstage w-25 colcompstage'>Taux</td>
                    <th class='titrecompstage w-25 colcompstage'>Date de lâché</td>
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
    <table class='tablerecap'>
        <tr><td class='titrerecap' colspan="3">Situation des stages</td></tr>
        <tr>
            <td class='ta-c'>
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

<pagebreak>
@foreach ($user->fonctions()->get() as $fonction)
    <bookmark content='{{$fonction->fonction_libcourt}}'  level='0' />
    <table class='tablecomp'>
        <tr class="4bords">
            <td colspan='6' class='titrefonction'>{{$fonction->fonction_libcourt}}</td>
        </tr>
    @foreach ($fonction->compagnonages()->get() as $comp)

        <bookmark content='{{$comp->comp_libcourt}}'  level='1' />
        <tr class="4bords">
            <td colspan='6' class='tdcomp'><strong>{{$comp->comp_libcourt}}</strong></td>
        </tr>
        <tr class="4bords">
            <td class='tdcomp w-15 br' >Tâche</td>
            <td class='tdcomp w-25 br'>Objectif</td>
            <td class='tdcomp w-35 br'>Détail du compagnonnage</td>
            <td class='tdcomp w-5 br'>Durée (j)</td>
            <td class='tdcomp w-15 br'>Date <br>Valideur</td>
            <td class='tdcomp w-5 '>Lieu form.</td>
        </tr>
        @php
            $libtachsauv=""; 
            $libobjsauv="";
        @endphp
        @foreach ($comp->taches()->get() as $tache)
            @foreach ($tache->objectifs()->get() as $objectif)
                @foreach ($objectif->sous_objectifs()->get() as $ssobj)
                    <tr>
                        @php
                            $libtach=$tache->tache_libcourt;
                        @endphp
                        @if ($libtach!=$libtachsauv)
                            <td class='ta-l va-t  w-15 br bl bt'>{{$tache->tache_libcourt}}</td>
                        @else
                            <td class='ta-l va-t  w-15 br bl'>&nbsp;</td>
                        @endif
                        @php
                            $libtachsauv=$libtach;
                        @endphp
                        @php
                            $libobj=$objectif->objectif_libcourt;
                        @endphp
                        @if ($libobj!=$libobjsauv)
                            <td class='ta-l va-t w-25 br bt'>{{$libobj}}</td>
                        @else
                            <td class='ta-l va-t w-25 br'>&nbsp;</td>
                        @endif
                        @php
                            $libobjsauv=$libobj;
                        @endphp
                        <td class="ta-l va-t h-20 w-35 4bords">{{$ssobj->ssobj_lib}} (coef :{{$ssobj->ssobj_coeff}})</td>
                        <td class="w-5 4bords">{{$ssobj->ssobj_duree}}</td>
                        <td class="w-15 4bords">
                            @if ($user->aValideLeSousObjectif($ssobj))
                                {{ $user->sous_objectifs()->find($ssobj)->pivot->date_validation }}
                            @endif 
                            <br>
                            @if ($user->aValideLeSousObjectif($ssobj))
                                {{ $user->sous_objectifs()->find($ssobj)->pivot->valideur }}
                            @endif
                        </td>
                        <td class="w-5 4bords">{{$ssobj->lieu()->get()->first()->lieu_libcourt}}</td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    @endforeach
    @if ($fonction->fonction_double)
            <tr class='trlache'>
            <td class='h-30 4bords'>DOUBLE</td>
            <td colspan='2' class="4bords">
            @if($fonction->pivot->date_double != null)
                {{ $fonction->pivot->commentaire_double }}
            @endif
            </td>
            <td class="4bords">
            @if($fonction->pivot->date_double != null)
                {{ $fonction->pivot->date_double }}
            @endif
            </td>
            <td class="4bords">
            @if($fonction->pivot->date_double != null)
                {{ $fonction->pivot->valideur_double }}
            @endif
            </td>
            <td class="4bords">Bord</td>
            </tr>
    @endif
    @if ($fonction->fonction_lache)
            <tr class='trlache'>
            <td class='h-30 4bords'>L&Acirc;CHER</td>
            <td colspan='2' class="4bords">
            @if($fonction->pivot->date_lache != null)
                {{ $fonction->pivot->commentaire_lache }}
            @endif
            </td>
            <td class="4bords">
            @if($fonction->pivot->date_lache != null)
                {{ $fonction->pivot->date_lache }}
            @endif
            </td>
            <td class="4bords">
            @if($fonction->pivot->date_lache != null)
                {{ $fonction->pivot->valideur_lache }}
            @endif
            </td>
            <td class="4bords">Bord</td>
            </tr>
    @endif
    </table>
    <br>
    <pagebreak>
@endforeach

    <bookmark content='Notes' level='0' />
    <table class='tablenote'>
        <tr><td colspan='3' class='titrenote'>P&eacute;riodes embarqu&eacute;es : MPE, renfort, service ...</td></tr>
        <tr>
            <th class='notedate h-20'>Dates</th>
            <th class='notebat'>B&acirc;timent</th>
            <th class='notecomment'>Commentaires</th>
        </tr>
        <tr>
            <td class='br-1 h-200'>&nbsp;</td>
            <td class='br-1'>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
</page>
