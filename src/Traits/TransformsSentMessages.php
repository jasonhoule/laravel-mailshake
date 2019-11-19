<?php

namespace Jhoule\Mailshake\Traits;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\EmailAddress;
use Jhoule\Mailshake\Models\SentMessage;

trait TransformsSentMessages
{
    use HasRecipient, HasCampaign, HasMessage;

    private function transformSentMessages(array $messages) : Collection
    {
        $sentMessages = new Collection();
        foreach ($messages as $message) {
            $sentMessages->push(new SentMessage([
                'id'                     => $message->id,
                'actionDate'             => $message->actionDate,
                'recipient'              => $this->getRecipient($message->recipient),
                'campaign'               => $this->getCampaign($message->campaign),
                'type'                   => $message->type,
                'message'                => $this->getMessage($message->message),
                'from'                   => $this->getEmailAddress($message->from),
                'to'                     => $this->getTo($message->to),
                'subject'                => $message->subject,
                'externalID'             => $message->externalID,
                'externalRawMessageID'   => $message->externalRawMessageID,
                'externalConversationID' => $message->externalConversationID,
                'rawBody'                => $message->rawBody,
                'body'                   => $message->body,
                'plainTextBody'          => $message->plainTextBody,
            ]));
        }

        return $sentMessages;
    }

    private function getEmailAddress($fromData) : EmailAddress
    {
        return new EmailAddress([
            'address'  => $fromData->address,
            'fullName' => $fromData->fullName,
            'first'    => $fromData->first,
            'last'     => $fromData->last,
        ]);
    }

    private function getTo($toData) : Collection
    {
        $to = new Collection();
        foreach ($toData as $each) {
            $to->push($this->getEmailAddress($each));
        }

        return $to;
    }
}
