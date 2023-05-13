<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationPanel extends Component
{
    public $showPanel=false;

    protected $listeners = ['$refresh'];

    public function render()
    {
        return view('livewire.notification-panel');
    }

    public function markNotificationAsRead($notification_id)
    {
        $this->showPanel=true;

        foreach (auth()->user()->unreadNotifications as $notification) {
            if ($notification->id == $notification_id) {
                $notification->markAsRead();
                $this->emitSelf('$refresh');
            }
        }
    }
}
