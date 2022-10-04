@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages - {{$marin->displayString()}}</h2>
    </div>
    
    <div id='divvalid' class='popupvalidcontrat' style='display:none;'>
        <div class='titrenavbarvert'>
            <h5>Validation</h5>
        </div>
        <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
        <input type='hidden' id='userid' name='userid' value=''>
        <input type='hidden' id='stageid' name='stageid' value=''>
        
        <div class='form-group row pl-3 mt-2' >
            <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
            <div class='col-sm-5'>
            <input type='date' class='form-control'name='date_validation' id='date_validation' value='{{date("Y-m-d")}}'>
            </div>
        </div>
        <div class='form-group row  pl-3' >
            <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
            <div class='col-sm-5'>
                <textarea cols='40' rows='4' name='commentaire' id='commentaire' placeholder='Commentaire'></textarea>
            </div>
        </div>
        <div class='text-center'>
            <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
            id='btnvalidobj' 
            name='btnvalidobj'
            onclick='divvalid = getElementById("divvalid");
                    annuler("divvalid");
                    formtosubmitid=divvalid.querySelector("#formtosubmit").value;
                    let userid=divvalid.querySelector("#userid").value;
                    let stageid=divvalid.querySelector("#stageid").value;
                    
                    formtosubmit = getElementById(formtosubmitid);
                    date_validation = divvalid.querySelector("#date_validation").value ;
                    commentaire = divvalid.querySelector("#commentaire").value.replaceAll("\n", "<br>") ;
                    console.log(commentaire);
                    formtosubmit.attributes[1].value="ValidateStage( " + userid + "," + stageid + ",\"" +commentaire + "\",\"" +date_validation +"\");";
                    formtosubmit.click();'
                        >Valider</button>
            <button class='btn btn-primary w-25 mt-4 mb-2' type='reset' form='formlivret' id='btnresetobj' name='btnresetobj' onclick='annuler("divvalid");'>Annuler</button>
        </div>
    </div>
    
    <div id='divconsultstage' class='card bg-light ml-3 w-100'>
        <div class='card-header'>Consultation des stages pour {{$marin->displayString()}}
        </div>
        
        
        @if ( $marin != null)
        <div class='mt-2 mb-2'> 
            <a href="{{ route('transformation.livret', $marin->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
            <a href="{{ route('transformation.progression', $marin->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation.fichebilan', $marin->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            <a href="{{ route('users.stages', $marin->id) }}" class="btn btn-danger btn-sm">Stages</a>
            <a href="{{ route('transformation.index') }}" class="btn btn-default btn-sm">Annuler</a>
       </div>
        <div class='mt-2 mb-2' style='margin-left:50%; text-align: center;'> </div>
        

        
        
        @livewire('stages-table', ['mode' => 'uservalidation', 'user' => $marin])
        
        @endif
    </div>
    {!! link_to_route('transformation.index', 'Annuler', [], ['class' => 'btn btn-primary']) !!}
@endsection