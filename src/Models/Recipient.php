<?php

namespace Jhoule\Mailshake\Models;

class Recipient extends MailshakeModel
{

    public $id;
    public $emailAddress;
    public $fullName;
    public $first;
    public $last;
    public $created;
    public $isPaused;
    public $fields;

}
