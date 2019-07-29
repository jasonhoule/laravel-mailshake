<?php

namespace Jhoule\Mailshake\Requests\Leads;

use Jhoule\Mailshake\Models\LeadStatus;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class Reopen extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.leads.reopen');

        parent::__construct();
    }

    /**
     * Takes a closed or ignored lead and makes it open again and available for review.
     *
     * @param int|null $campaignID If emailAddress is passed without campaignID, we will use your latest campaign.
     * @param string|null $emailAddress The email address of a recipient in this campaign.
     * @param int|null $recipientID The ID of the recipient that this lead refers to.
     * @param int|null $leadID The ID of the lead.
     * @return LeadStatus
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public function get(
        int $campaignID = null,
        string $emailAddress = null,
        int $recipientID = null,
        int $leadID = null
    ) : LeadStatus
    {
        $response = $this->sendRequest([
            'campaignID' => $campaignID,
            'emailAddress' => $emailAddress,
            'recipientID' => $recipientID,
            'leadID' => $leadID,
        ]);

        return new LeadStatus(['status' => $response->status, 'leadID' => $response->leadID]);
    }

}
