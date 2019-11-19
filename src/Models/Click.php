<?php

namespace Jhoule\Mailshake\Models;

class Click extends MailshakeModel
{
    public $id;
    public $link;
    public $actionDate;
    public $isDuplicate;
    public $recipient;
    public $campaign;
    public $parent;
}
