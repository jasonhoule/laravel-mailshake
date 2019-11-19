<?php

namespace Jhoule\Mailshake\Traits;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Message;

trait TransformsMessages
{
    /**
     * Transform the message array to a collection of Message objects.
     *
     * @param array $campaignMessages
     *
     * @return Collection
     */
    private function transformMessages(array $campaignMessages) : Collection
    {
        $messages = [];
        foreach ($campaignMessages as $each) {
            $messages[] = new Message([
                'id'        => $each->id,
                'type'      => $each->type,
                'subject'   => $each->subject,
                'replyToID' => $each->replyToID,
                'isPaused'  => $each->isPaused,
            ]);
        }

        return collect($messages);
    }
}
