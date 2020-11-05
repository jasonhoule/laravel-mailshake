<?php

namespace Jhoule\Mailshake\Models;

class Campaign extends MailshakeModel
{
    public $id;
    public $title;
    public $created;
    public $isArchived;
    public $isPaused;
    public $messages;
    public $sender;
    public $url;
}
