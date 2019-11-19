<?php

namespace Jhoule\Mailshake\Requests\Push;

use Jhoule\Mailshake\Requests\MailshakeRequest;

class Delete extends MailshakeRequest
{
    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.push.delete');

        parent::__construct();
    }

    /**
     * Unsubscribes a push you previously created. Since all subscribed pushes
     * require a unique targetUrl, that’s all you need to send in to delete
     * your push.
     *
     * @param string $targetUrl The unique target url of a push.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     *
     * @return bool
     */
    public function get(string $targetUrl) : bool
    {
        $this->sendRequest(['targetUrl' => $targetUrl]);

        return true;
    }
}
