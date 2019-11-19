<?php

namespace Jhoule\Mailshake\Models;

class Reply extends MailshakeModel
{
    public $id;
    public $actionDate;
    public $recipient;
    public $campaign;
    public $type;
    public $parent;
    public $subject;
    public $externalID;
    public $externalRawMessageID;
    public $externalConversationID;
    public $rawBody;
    public $body;
    public $plainTextBody;
}
