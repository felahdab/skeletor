@if ($user->aValideLeStage($row))
    
<button wire:click.prevent="UnvalidateStage( {{$user->id}}, {{$row->id}} );"
        class="btn btn-danger">Annuler ce stage</button>

@else

<button class="btn btn-success" 
        x-on:click.prevent="stageid= {{ $row->id }};
	                    opendivvalid = true;     "
	x-on:uservalidated.window="if(stageid=={{ $row->id }})
            {
	       $wire.ValidateStage( {{ $user->id }} , {{ $row->id }}, commentaire, date_validation);
            }">Valider ce stage</button>

@endif

<a href="{{route('stages.show', $row->id)}}" class="btn btn-primary">Situation des marins pour ce stage</a>
