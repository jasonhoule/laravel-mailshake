<?php

namespace Jhoule\Mailshake\Models;

class Lead extends MailshakeModel
{
    public $id;
    public $created;
    public $openDate;
    public $lastStatusChangeDate;
    public $recipient;
    public $campaign;
    public $status;
    public $assignedTo;
}
