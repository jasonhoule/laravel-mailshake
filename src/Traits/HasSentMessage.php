<?php

namespace Jhoule\Mailshake\Traits;

use Jhoule\Mailshake\Models\SentMessage;

trait HasSentMessage
{
    use HasMessage;

    private function getSentMessage($message): SentMessage
    {
        $sentMessage = new SentMessage();

        if (!empty($message)) {
            $sentMessage->fill([
                'id'      => $message->id,
                'type'    => $message->type,
                'message' => $this->getMessage($message->message),
            ]);
        }

        return $sentMessage;
    }
}
