<?php

namespace Jhoule\Mailshake\Traits;

use Jhoule\Mailshake\Models\Recipient;

trait HasRecipient
{
    private function getRecipient($recipientData) : Recipient
    {
        return new Recipient([
            'id'           => $recipientData->id,
            'emailAddress' => $recipientData->emailAddress,
            'fullName'     => $recipientData->fullName,
            'created'      => $recipientData->created,
            'isPaused'     => $recipientData->isPaused,
            'first'        => $recipientData->first,
            'last'         => $recipientData->last,
            'fields'       => $recipientData->fields,
        ]);
    }
}
