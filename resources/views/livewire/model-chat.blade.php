<div x-cloak x-data='{show : false, newSubject:"", newBody: ""}'>
    <div x-show="show">
        <button class='btn btn-sm btn-danger' x-on:click="show = false"><x-bootstrap-icon iconname='x-square.svg' /></button>
        @foreach($chat_threads as $thread)
        <div class='mt-4 card'>
            <div class="card-title">{{ $thread->subject }}</div>
            
                @foreach($thread->messages as $message)
                <div class='card mx-4 mt-2 @if($loop->index % 2) text-end @endif' @if($loop->index % 2) style='border-color: #ccc; background-color: #ddd;' @endif>
                    <div class="card-body">
                        <div class="card-title">
                            {{ $message->created_at }} 
                            {{ $message->author }} 
                            <button class='btn btn-danger btn-sm' 
                                    wire:click="deleteMessage({{ $thread->id }}, {{ $message->id }})"
                                    wire:confirm="Vous voulez vraiment supprimer ce message ?">
                                <x-bootstrap-icon iconname='trash.svg' />
                            </button>
                        </div>
                        <div class='card-text'>
                            {{ $message->body }}
                        </div>
                    </div>
                </div>
                @endforeach
                <form wire:submit="postMessage({{ $thread->id }}, newBody)" class='mt-4 mx-2 mb-4'> 
                    <input type='text' x-model='newBody'>
                    <button class='btn btn-primary' type="submit"><x-bootstrap-icon iconname='send.svg' /></button>
                </form>
            
        </div>
        @endforeach
        <form wire:submit="addThread(newSubject)" class='mt-4'> 
            <input type='text' x-model='newSubject'>
            <button class='btn btn-primary' type="submit">Ajouter un nouveau sujet de discussion</button>
        </form>
    </div>
    <div x-show="! show">
        <button class='btn btn-sm btn-primary' x-on:click="show = true"><x-bootstrap-icon iconname='chat-dots.svg' /></button>
    </div>
</div>
