<?php

namespace Jhoule\Mailshake\Errors;

class LimitReached extends MailshakeError
{
    private const MAILSHAKE_CODE = 'limit_reached';
}
