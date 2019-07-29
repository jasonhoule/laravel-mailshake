<?php

namespace Jhoule\Mailshake\Traits;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Recipient;

trait TransformsRecipients
{

    private function transformRecipients(array $recipients) : Collection
    {
        $campaignRecipients = new Collection();
        foreach($recipients as $recipient) {
            $campaignRecipients->push(new Recipient([
                'id' => $recipient->id,
                'emailAddress' => $recipient->emailAddress,
                'fullName' => $recipient->fullName,
                'created' => $recipient->created,
                'isPaused' => $recipient->isPaused,
                'first' => $recipient->first,
                'last' => $recipient->last,
                'fields' => $recipient->fields
            ]));
        }

        return $campaignRecipients;
    }
}
