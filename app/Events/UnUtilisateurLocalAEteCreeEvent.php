<?php

namespace App\Events;

use App\DataObjects\NewUserDescriptionData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnUtilisateurLocalAEteCreeEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public NewUserDescriptionData $description;

    /**
     * Create a new event instance.
     */
    public function __construct(array $data)
    {
        $this->description = NewUserDescriptionData::make($data['nom'], 
                                                          $data['prenom'], 
                                                          $data['email'], 
                                                          $data['unite'], 
                                                          nid: $data['nid'], 
                                                          gradelong: $data['gradelong']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
