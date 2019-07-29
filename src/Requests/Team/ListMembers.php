<?php

namespace Jhoule\Mailshake\Requests\Team;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\User;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class ListMembers extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.team.list-members');

        parent::__construct();
    }

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
    public function get(string $search = null, string $nextToken = null, int $perPage = 100) : Collection
    {
        $response = $this->sendRequest([
            'search' => $search,
            'nextToken' => $nextToken,
            'perPage' => $perPage,
        ]);

        $users = new Collection();
        foreach($response->results as $user) {
            $users->push(new User([
                'id' => $user->id,
                'teamID' => $user->teamID,
                'emailAddress' => $user->emailAddress,
                'fullName' => $user->fullName,
                'first' => $user->first,
                'last' => $user->last,
                'isTeamAdmin' => $user->isTeamAdmin,
                'isDisabled' => $user->isDisabled,
            ]));
        }

        return collect(['nextToken' => $response->nextToken, 'users' => $users]);
    }

}
