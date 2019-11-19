<?php

namespace Jhoule\Mailshake\Models;

class AddRecipientRequest extends MailshakeModel
{
    public $invalidEmails;
    public $isEmpty;
    public $checkStatusID;
}
