<?php

namespace Jhoule\Mailshake\Facades;

use Jhoule\Mailshake\Requests\Push\Create;
use Jhoule\Mailshake\Requests\Push\Delete;

class Push
{

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
    public static function create(string $targetUrl, string $event, array $filter = null) : int
    {
        $request = new Create();
        return $request->get($targetUrl, $event, $filter);
    }

    public static function delete(string $targetUrl) : bool
    {
        $request = new Delete();
        return $request->get($targetUrl);
    }

}
