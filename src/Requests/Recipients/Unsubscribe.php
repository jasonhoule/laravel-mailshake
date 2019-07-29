<?php

namespace Jhoule\Mailshake\Requests\Recipients;

use Jhoule\Mailshake\Requests\MailshakeRequest;

class Unsubscribe extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.recipients.unsubscribe');

        parent::__construct();
    }

    /**
     * Adds a list of email addresses to your unsubscribe list.
     *
     * @param array $emailAddresses A comma-separated list of email addresses to unsubscribe.
     * @return bool Returns true if successful
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public function get(array $emailAddresses) : bool
    {
        $this->sendRequest(['emailAddresses' => $emailAddresses]);

        return true;
    }
}
