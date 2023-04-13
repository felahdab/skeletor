
@if ($datvalid=$user->dateValidationDuStage($row))
    <span class="badge bg-success" style="width: 80px;">{{$datvalid}}</span>
@else
    <span class="badge bg-danger" style="width: 80px;">N.C.</span>
@endif
@can('stages.attribuerstage')
    <!-- ajout d'un bouton pour pouvoir mettre à jour le commentaire associé a un stage pour un user-->
    <button class="btn btn-info" 
            x-on:click.prevent='stageid= {{ $row->id }};
                                commentaire = "{{ $user->CommentaireDuStage($row) }}";
                                opendivvalidcomment = true;
                                libstage = "{{ $row->stage_libcourt }}";
                                nommarin = "{{ $user->display_name }}";'
            x-on:usercommentvalidated.window="if(stageid=={{ $row->id }})
                {
               $wire.ValidateCommentStage( {{ $user->id }} , {{ $row->id }}, commentaire);
                }"
            title="{{$user->CommentaireDuStage($row)}}">&#169;</button>
    <!----------------------------------------------->
    @if ($user->aValideLeStage($row))
    <button wire:click.prevent="UnvalidateStage( {{$user->id}}, {{$row->id}} );"
            class="btn btn-danger">Annuler ce stage</button>
    @else
    <button class="btn btn-success" 
            x-on:click.prevent="stageid= {{ $row->id }};
                            date_validation = '{{ date('Y-m-d') }}'; 
                            commentaire = '{{ $user->CommentaireDuStage($row) }}';
                            opendivvalid = true;     "
            x-on:uservalidated.window="if(stageid=={{ $row->id }})
                {
               $wire.ValidateStage( {{ $user->id }} , {{ $row->id }}, commentaire, date_validation);
                }">Valider ce stage</button>
    @endif
@endcan

<a href="{{route('stages.show', $row->id)}}" class="btn btn-primary">Situation des marins pour ce stage</a>
@can('stages.attribuerstage')
    @if ( ! array_key_exists($row->id,  $user->stagesLiesAUneFonction()->pluck('id','id')->toArray() ) )
    <button wire:click.prevent="RetirerStage( {{$user->id}}, {{$row->id}} );"
            class="btn btn-danger">Retirer ce stage</button>
    @endif
@endcan