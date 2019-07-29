<?php

namespace Jhoule\Mailshake\Requests\Campaigns;

use Jhoule\Mailshake\Requests\MailshakeRequest;

class Unpause extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.campaign.unpause');
        parent::__construct();
    }

    /**
     * Resumes sending for a campaign. This team’s sending calendar will reschedule
     * itself to account for this campaign’s pending emails. In rare cases it may
     * take up to 5 minutes for the calendar to show scheduled times for this campaign.
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
