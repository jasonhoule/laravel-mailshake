<?php

namespace Jhoule\Mailshake\Traits;

use Jhoule\Mailshake\Models\Sender;

trait TransformsSender
{
    /**
     * Transform the sender data to a Sender object.
     *
     * @param object $senderData
     *
     * @return Sender
     */
    private function transformSender($senderData): Sender
    {
        return new Sender([
            'id'           => $senderData->id,
            'emailAddress' => $senderData->emailAddress,
            'fromName'     => $senderData->fromName,
            'created'      => $senderData->created,
        ]);
    }
}
