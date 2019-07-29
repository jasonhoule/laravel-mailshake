<?php

namespace Jhoule\Mailshake\Models;

class ReplyType extends MailshakeModel
{

    public const BOUNCE = 'bounce';
    public const DELAY_NOTIFICATION = 'delay-notification';
    public const OUT_OF_OFFICE = 'out-of-office';
    public const REPLY = 'reply';
    public const UNSUBSCRIBE = 'unsubscribe';

}
