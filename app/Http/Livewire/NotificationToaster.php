<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationToaster extends Component
{
    public $notification;

    public function render()
    {
        return view('livewire.notification-toaster');
    }

    public function markAsRead()
    {
        $this->notification->markAsRead();
    }
}
