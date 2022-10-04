@if ($user->aValideLeStage($row))
    
<button wire:click.prevent="UnvalidateStage( {{$user->id}}, {{$row->id}} );"
class="btn btn-danger">Annuler ce stage</button>

@else

<input type='hidden' id='date_validation' name='date_validation' value=''>
<input type='hidden' id='commentaire' name='commentaire' value=''>
<input type='hidden' id='valideur' name='valideur' value=''>
<input type='hidden' id='user[{{ $user->id }}]' name='user[{{ $user->id }}]' value='user[{{ $user->id }}]'>

<button type="submit" 
    class="btn btn-success" 
    name="validation_double"
    onclick='divvalid = getElementById("divvalid");
            divvalid.querySelector("#formtosubmit").value="button[{{$row->id}}]";
            divvalid.querySelector("#userid").value="{{ $user->id }}";
            divvalid.querySelector("#stageid").value="{{ $row->id }}";

            affichage("divvalid");
            return false;'>Valider ce stage</button>


<button id='button[{{$row->id}}]' wire:click.prevent="" style="display:none;">Test</button>
@endif

<a href="{{route('stages.show', $row->id)}}" class="btn btn-primary">Situation des marins pour ce stage</a>