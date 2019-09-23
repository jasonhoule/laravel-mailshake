<?php

namespace Jhoule\Mailshake;

use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Models\User;

class Me extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.me');
        parent::__construct();
    }

    /**
     * Calls the Mailshake API to return the user for the given API key
     *
     * @return User
     */
    public function get() : User
    {
        $response = $this->sendRequest()->user;

        $user = new User([
            'id' => $response->id,
            'teamID' => $response->teamID,
            'teamName' => $response->teamName,
            'teamBlockedDate' => $response->teamBlockedDate,
            'emailAddress' => $response->emailAddress,
            'isTeamAdmin' => $response->isTeamAdmin,
            'isDisabled' => $response->isDisabled,
            'fullName' => $response->fullName,
        ]);

        return $user;
    }
}
