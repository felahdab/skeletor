<td>
<a href="{{route('stages.show', $row->id)}}" class="btn btn-warning">Voir ce stage</a>

@if ($user->aValideLeStage($row))
    

{!! Form::open(['method' => 'POST','route' => ['stages.annulermarins', $row->id], 'id' => 'form[' . $row->id . ']']) !!}
<input type='hidden' id='usercancel[{{ $user->id }}]' name='usercancel[{{ $user->id }}]' value='usercancel[{{ $user->id }}]'>
<button wire:click.prevent="UnvalidateStage( {{$user->id}}, {{$row->id}} )"
class="btn btn-danger">Annuler ce stage</button>
{!! Form::close() !!}


@else
    
{!! Form::open(['method' => 'POST','route' => ['stages.validermarins', $row->id], 'id' => 'form[' . $row->id . ']']) !!}
<input type='hidden' id='date_validation' name='date_validation' value=''>
<input type='hidden' id='commentaire' name='commentaire' value=''>
<input type='hidden' id='valideur' name='valideur' value=''>
<input type='hidden' id='user[{{ $user->id }}]' name='user[{{ $user->id }}]' value='user[{{ $user->id }}]'>

<button type="submit" 
                    class="btn btn-primary" 
                    name="validation_double"
                    onclick='divvalid = getElementById("divvalid");
                            parentForm = jQuery(this).closest("form");
                            divvalid.querySelector("#formtosubmit").value="button[{{$row->id}}]";
                            divvalid.querySelector("#userid").value="{{ $user->id }}";
                            divvalid.querySelector("#stageid").value="{{ $row->id }}";

                            affichage("divvalid");
                            return false;'>Valider ce stage</button>
{!! Form::close() !!}

<button id='button[{{$row->id}}]' wire:click.prevent="" style="display:none;">Test</button>
@endif
</td>
