<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\DataObjects\NewUserDescriptionData;

class UnUtilisateurLocalDoitEtreCreeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public NewUserDescriptionData $description;
    /**
     * Create a new event instance.
     */
    public function __construct(array $data, public array $roles)
    {
        $this->description = NewUserDescriptionData::make($data["nom"], $data["prenom"], $data["email"]);
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
