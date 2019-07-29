<?php

namespace Jhoule\Mailshake\Requests\Push;

use Jhoule\Mailshake\Requests\MailshakeRequest;

class Create extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.push.create');

        parent::__construct();
    }

    /**
     * Starts a subscription for a type of push.
     *
     * @param string $targetUrl The publicly accessible url to your servers that we should send a POST request to.
     * @param string $event The type of event you’re subscribing to.
     * @param array|null $filter If you only want subscriptions when certain criteria are met, specify them as an array.
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public function get(string $targetUrl, string $event, array $filter = null) : int
    {
        $response = $this->sendRequest([
            'targetUrl' => $targetUrl,
            'event' => $event,
            'filter' => $filter,
        ]);

        return $response->id;
    }

}
