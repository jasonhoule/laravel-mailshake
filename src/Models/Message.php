<?php

namespace Jhoule\Mailshake\Models;

class Message extends MailshakeModel
{

    public $id;
    public $type;
    public $subject;
    public $replyToID;
    public $isPaused;

}
