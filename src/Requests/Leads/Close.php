<?php

namespace Jhoule\Mailshake\Requests\Leads;

use Jhoule\Mailshake\Requests\MailshakeRequest;

class Close extends MailshakeRequest
{
    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.leads.close');

        parent::__construct();
    }

    /**
     * Marks a lead as “Won” (or “Lost” if you send in that status). The alternative
     * to these states is “Ignored” which means that the lead wasn’t worth pursuing.
     *
     * @param int|null    $campaignID   If emailAddress is passed without campaignID, we will use your latest campaign.
     * @param string|null $emailAddress The email address of a recipient in this campaign.
     * @param int|null    $recipientID  The ID of the recipient that this lead refers to.
     * @param int|null    $leadID       The ID of the lead.
     * @param string|null $status       Can be set to “closed” or “lost”.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     *
     * @return bool
     */
    public function get(
        int $campaignID = null,
        string $emailAddress = null,
        int $recipientID = null,
        int $leadID = null,
        string $status = null
    ): bool {
        $this->sendRequest([
            'campaignID'   => $campaignID,
            'emailAddress' => $emailAddress,
            'recipientID'  => $recipientID,
            'leadID'       => $leadID,
            'status'       => $status,
        ]);

        return true;
    }
}
