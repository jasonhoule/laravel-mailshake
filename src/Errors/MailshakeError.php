<?php

namespace Jhoule\Mailshake\Errors;

use Throwable;

class MailshakeError extends \Exception
{
    public $time;
    private const MAILSHAKE_CODE = 'mailshake_error';

    public function __construct(string $message, int $code, Throwable $previous = null, string $time)
    {
        $this->time = $time;

        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__.": [{$this->MAILSHAKE_CODE}] {$this->time}: {$this->message}\n";
    }
}
