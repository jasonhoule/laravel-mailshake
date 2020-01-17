<?php

namespace Jhoule\Mailshake\Traits;

use Jhoule\Mailshake\Models\Message;

trait HasMessage
{
    private function getMessage($messageData): Message
    {
        return new Message([
            'id'        => $messageData->id,
            'type'      => $messageData->type,
            'subject'   => $messageData->subject,
            'replyToID' => $messageData->replyToID,
        ]);
    }
}
