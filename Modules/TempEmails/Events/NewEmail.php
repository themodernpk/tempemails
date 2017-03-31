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

    public $mail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TeMail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {

        return new PrivateChannel('account.'.$this->mail->account->id);
    }

    public function broadcastWith()
    {
        return ['id' => $this->mail->id];
    }


    public function broadcastAs()
    {
        return 'email.created';
    }

}
