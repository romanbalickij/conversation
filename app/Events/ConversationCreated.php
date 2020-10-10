<?php

namespace App\Events;

use App\Models\Conversation;
use App\Transformers\ConversationTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;


    public function __construct( $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];

        $this->conversation->usersExceptCurrentlyAuthenticated->each(function ($user) use (&$channels){

            $channels = new PrivateChannel('user.'.$user->id);

        });

        return $channels;


    }


    public function broadcastWith() {

        return fractal()
            ->item($this->conversation)
            ->parseIncludes(['user','users'])
            ->transformWith(new ConversationTransformer)
            ->toArray();
    }
}
