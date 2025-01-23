<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;

use App\Models\ChatThread;
use App\Models\ChatMessage;

class ModelChat extends Component
{
    public Model $model;

    //public string $newSubject = '';
    //public string $newBody = '';

    public function mount(Model $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        $chat_threads = ChatThread::forModel($this->model);

        return view('livewire.model-chat', compact('chat_threads'));
    }

    public function addThread($subject)
    {
        $newThread = new ChatThread();
        $newThread->subject = $subject;
        $newThread->aboutmodel()->associate($this->model);
        $newThread->save();
    }

    public function postMessage($threadid, $body)
    {
        $c = ChatThread::find($threadid);
        if ($c->aboutmodel != $this->model)
            return;

        $m = new ChatMessage();
        $m->author = auth()->user()->display_name;
        $m->body = $body;
        $m->save();
        $c->messages()->attach($m);
    }

    public function deleteMessage($threadid, $messageid)
    {
        
        $c = ChatThread::find($threadid);
        if ($c->aboutmodel != $this->model)
            return;
            
        $m = ChatMessage::find($messageid);
        if (!$c->messages->contains($m))
            return;
           
        if ($m->author != auth()->user()->display_name)
            return;
            
        $c->messages()->detach($m);
        $m->delete();
    }
}
