<?php

namespace Jhoule\Mailshake\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jhoule\Mailshake\Requests\Team\ListMembers;

class Team extends Facade
{

    /**
     * Lists the users belonging to this team.
     *
     * @param string|null $search Filters the returned users.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function listMembers(
        string $search = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new ListMembers();
        return $request->get($search, $nextToken, $perPage);
    }

}
