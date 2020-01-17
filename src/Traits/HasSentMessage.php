<?php

namespace Jhoule\Mailshake\Traits;

use Jhoule\Mailshake\Models\SentMessage;

trait HasSentMessage
{
    use HasMessage;

    private function getSentMessage($message): SentMessage
    {
        return new SentMessage([
            'id'      => $message->id,
            'type'    => $message->type,
            'message' => $this->getMessage($message->message),
        ]);
    }
}
