<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DrawLine implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stroke;
    public $option;
    public $id;

    public function __construct($stroke, $option, $id)
    {
        $this->stroke = $stroke;
        $this->option = $option;
        $this->id = $id;
    }

    public function broadcastOn()
    {
        return ['channel-' . $this->id];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
