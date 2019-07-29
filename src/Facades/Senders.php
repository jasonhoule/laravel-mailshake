<?php

namespace Jhoule\Mailshake\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jhoule\Mailshake\Requests\Senders\SendersList;

class Senders extends Facade
{

    /**
     * List all of a team’s senders.
     *
     * @param string|null $search Filters what senders are returned.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function list(string $search = null, string $nextToken = null, int $perPage = 100) : Collection
    {
        $request = new SendersList();
        return $request->get($search, $nextToken, $perPage);
    }

}
