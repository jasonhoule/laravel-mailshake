<?php

namespace Jhoule\Mailshake\Models;

class User extends MailshakeModel
{

    public $id;
    public $teamID;
    public $teamName;
    public $isTeamAdmin;
    public $isDisabled;
    public $emailAddress;
    public $fullName;
    public $first;
    public $last;
    public $teamBlockedDate;

}
