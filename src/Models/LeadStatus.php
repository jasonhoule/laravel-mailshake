<?php

namespace Jhoule\Mailshake\Models;

class LeadStatus extends MailshakeModel
{
    public const CLOSED = 'closed';
    public const IGNORED = 'ignored';
    public const LOST = 'lost';
    public const OPEN = 'open';

    public $status;
    public $leadID;
}
