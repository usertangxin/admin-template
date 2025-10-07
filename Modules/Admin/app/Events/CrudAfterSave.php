<?php

namespace Modules\Admin\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Admin\Http\Controllers\AbstractCrudController;

class CrudAfterSave implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Model $model, public mixed $data, protected AbstractCrudController $controller) {}

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return $this->controller->getBroadcastOn($this);
    }
}
