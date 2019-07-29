<?php

namespace Jhoule\Mailshake\Requests\Leads;

use Jhoule\Mailshake\Models\CreatedLeads;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\TransformsLeads;

class Create extends MailshakeRequest
{
    use TransformsLeads;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.leads.create');

        parent::__construct();
    }

    /**
     * Creates one or more leads from recipients of a campaign. You can either pass
     * in the IDs of recipients or if it’s easier, you can pass their email
     * addresses instead. If a recipient was already a lead and was won,
     * this will reopen them as a lead.
     *
     * @param int|null $campaignID
     * @param array|null $emailAddresses
     * @param int|null $recipientIDs
     * @return CreatedLeads
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public function get(
        int $campaignID = null,
        array $emailAddresses = null,
        int $recipientIDs = null
    ) : CreatedLeads
    {
        $response = $this->sendRequest([
            'campaignID' => $campaignID,
            'emailAddresses' => $emailAddresses,
            'recipientIDs' => $recipientIDs,
        ]);

        return new CreatedLeads([
            'leads' => $this->transformLeads($response->leads),
            'emailsNotFound' => $response->emailsNotFound,
            'recipientIDsNotFound' => $response->recipientIDsNotFound,
            'invalidEmails' => $response->invalidEmails,
            'isEmpty' => $response->isEmpty
        ]);
    }

}
