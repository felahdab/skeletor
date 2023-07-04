
@if ($datvalid=$user->dateValidationDuStage($row))
    @if($datvalid > date('Y-m-d'))
        <span class="badge" style="width: 80px; background-color:orange;">{{$datvalid}}</span>
    @else
        <span class="badge bg-success" style="width: 80px;">{{$datvalid}}</span>
    @endif
@else
    <span class="badge bg-danger" style="width: 80px;">N.C.</span>
@endif
@can('transformation::stages.attribuerstage')
    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" 
        @if (trim($user->CommentaireDuStage($row)))
            data-bs-title="{{trim($user->CommentaireDuStage($row))}}"
        @endif
    >
    <button class="btn btn-info" 
        data-bs-toggle="modal"
        data-bs-target="#divvalidcomment"
        x-on:click.prevent='stageid= {{ $row->id }};
                            commentaire = "{{ $user->CommentaireDuStage($row) }}";
                            opendivvalidcomment = true;
                            libstage = "{{ $row->stage_libcourt }}";
                            nommarin = "{{ $user->display_name }}";'
        x-on:usercommentvalidated.window="if(stageid=={{ $row->id }})
            {
            $wire.ValidateCommentStage( {{ $user->id }} , {{ $row->id }}, commentaire);
            }"
        ><x-bootstrap-icon iconname='chat-left-quote.svg' /></button></span>
    @if ($user->aValideLeStage($row))
    <button wire:click.prevent="UnvalidateStage( {{$user->id}}, {{$row->id}} );"
            class="btn btn-danger">Annuler ce stage</button>
    @else

        <button class="btn btn-success" 
            data-bs-toggle="modal"
            data-bs-target="#divvalid"
            x-on:click.prevent="stageid= {{ $row->id }};
                            date_validation = '{{ date('Y-m-d') }}'; 
                            commentaire = '{{ htmlspecialchars(trim($user->CommentaireDuStage($row))) }}';
                            opendivvalid = true;     "
            x-on:uservalidated.window="if(stageid=={{ $row->id }})
                {
               $wire.ValidateStage( {{ $user->id }} , {{ $row->id }}, commentaire, date_validation);
                }">Valider ce stage</button>
    @endif
@endcan

<a href="{{route('transformation::stages.show', $row->id)}}" class="btn btn-primary">Situation des marins pour ce stage</a>
@can('transformation::stages.attribuerstage')
    @if ( ! array_key_exists($row->id,  $user->stagesLiesAUneFonction()->pluck('id','id')->toArray() ) )
    <button wire:click.prevent="RetirerStage( {{$user->id}}, {{$row->id}} );"
            class="btn btn-danger">Retirer ce stage</button>
    @endif
@endcan

@section('scripts')
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
@endsection