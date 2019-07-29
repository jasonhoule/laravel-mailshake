<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/19/19
 * Time: 6:15 PM
 */

namespace Jhoule\Mailshake\Models;


class CreatedLeads extends MailshakeModel
{

    public $leads;
    public $emailsNotFound;
    public $invalidEmails;
    public $recipientIDsNotFound;
    public $isEmpty;

}
