<?php

namespace Jhoule\Mailshake\Requests\Leads;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Lead;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\HasCampaign;
use Jhoule\Mailshake\Traits\HasRecipient;

class LeadsList extends MailshakeRequest
{
    use HasRecipient, HasCampaign;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.leads.list');

        parent::__construct();
    }

    /**
     * Lists your leads. You can use this endpoint to search leads, filter
     * by status, or find leads assigned to one of your teammates.
     *
     * @param int|null    $campaignID             Filter leads to the ones from this campaign.
     * @param string|null $status                 Filter to leads in a particular status.
     * @param string|null $assignedToEmailAddress Leads assigned to this teammate.
     * @param string|null $search                 Filters what leads are returned.
     * @param string|null $nextToken              Fetches the next page from a previous request.
     * @param int         $perPage                How many results to get at once, up to 100.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return Collection
     */
    public function get(
        int $campaignID = null,
        string $status = null,
        string $assignedToEmailAddress = null,
        string $search = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection {
        $response = $this->sendRequest([
            'campaignID'             => $campaignID,
            'status'                 => $status,
            'assignedToEmailAddress' => $assignedToEmailAddress,
            'search'                 => $search,
            'nextToken'              => $nextToken,
            'perPage'                => $perPage,
        ]);

        $leads = new Collection();
        foreach ($response->results as $lead) {
            $leads->push(new Lead([
                'id'                   => $lead->id,
                'created'              => $lead->created,
                'openedDate'           => $lead->openedDate,
                'lastStatusChangeDate' => $lead->lastStatusChangeDate,
                'annotation'           => $lead->annotation,
                'recipient'            => $this->getRecipient($lead->recipient),
                'campaign'             => $this->getCampaign($lead->campaign),
                'status'               => $lead->status,
            ]));
        }

        return collect(['nextToken' => $response->nextToken, 'leads' => $leads]);
    }
}
