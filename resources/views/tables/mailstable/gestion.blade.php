<a href="{{ route('mails.edit', $row->id) }}" class="btn btn-info btn-sm">Modifier</a>
<button class="btn btn-danger btn-sm" wire:click="deleteMail({{$row->id}})">Supprimer</button>