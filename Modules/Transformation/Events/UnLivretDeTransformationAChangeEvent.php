<?php

namespace Modules\Transformation\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Modules\Transformation\Dto\ChangementLivretDeTransformationDto;

use Illuminate\Support\Facades\Log;

class UnLivretDeTransformationAChangeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ChangementLivretDeTransformationDto $data)
    {
        Log::info("Initialized UnLivretDeTransformationAChangeEvent" . $data->toJson());
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('channel-name'),
    //     ];
    // }
}
