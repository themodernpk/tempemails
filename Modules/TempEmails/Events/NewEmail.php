<?php

namespace Modules\TempEmails\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\Broadcaster;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Modules\TempEmails\Entities\TeMail;

class NewEmail implements ShouldBroadcast
{
    use SerializesModels;

    public $account_id;
    public $message_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($account_id, $message_id)
    {
        $this->account_id = $account_id;
        $this->message_id = $message_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('account.'.$this->account_id);
    }



    public function broadcastWith()
    {
        return ['id' => $this->message_id];
    }


    public function broadcastAs()
    {
        return 'email.created';
    }

}
