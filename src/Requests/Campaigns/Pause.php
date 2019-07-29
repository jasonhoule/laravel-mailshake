<?php

namespace Jhoule\Mailshake\Requests\Campaigns;

use Jhoule\Mailshake\Requests\MailshakeRequest;

class Pause extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.campaign.pause');
        parent::__construct();
    }

    /**
     * Immediately pauses all sending for a campaign. If a batch of emails for this campaign
     * is currently being sent they will not be stopped.
     *
     * @param int $campaignID
     * @return bool
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public function get(int $campaignID) : bool
    {
        $this->sendRequest(['campaignID' => $campaignID]);

        return true;
    }
}
