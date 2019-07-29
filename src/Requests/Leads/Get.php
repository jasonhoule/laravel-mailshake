<?php

namespace Jhoule\Mailshake\Requests\Leads;

use Jhoule\Mailshake\Models\Lead;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\HasCampaign;
use Jhoule\Mailshake\Traits\HasRecipient;

class Get extends MailshakeRequest
{
    use HasRecipient, HasCampaign;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.leads.get');

        parent::__construct();
    }

    /**
     * Gets a single lead. A not_found error will be returned if the lead could not be found.
     *
     * @param int|null $leadID The ID of a lead.
     * @param int|null $recipientID The ID of the recipient that this lead is for.
     * @param int|null $campaignID The campaign that this recipient belongs to. Required if emailAddress is specified.
     * @param string|null $emailAddress The address of the recipient.
     * @return Lead
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public function get(
        int $leadID = null,
        int $recipientID = null,
        int $campaignID = null,
        string $emailAddress = null
    ) : Lead
    {
        $response = $this->sendRequest([
            'leadID' => $leadID,
            'recipientID' => $recipientID,
            'campaignID' => $campaignID,
            'emailAddress' => $emailAddress,
        ]);

        return new Lead([
            'id' => $response->id,
            'created' => $response->created,
            'openedDate' => $response->openedDate,
            'lastStatusChangeDate' => $response->lastStatusChangeDate,
            'annotation' => $response->annotation,
            'recipient' => $this->getRecipient($response->recipient),
            'campaign' => $this->getCampaign($response->campaign),
            'status' => $response->status,
        ]);
    }

}
