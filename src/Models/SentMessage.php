<?php

namespace Jhoule\Mailshake\Models;

class SentMessage extends MailshakeModel
{
    public $id;
    public $actionDate;
    public $recipient;
    public $campaign;
    public $type;
    public $message;
    public $from;
    public $to;
    public $subject;
    public $externalID;
    public $externalRawMessageID;
    public $externalConversationID;
    public $rawBody;
    public $body;
    public $plainTextBody;
}
