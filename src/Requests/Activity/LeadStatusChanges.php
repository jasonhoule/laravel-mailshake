<?php

namespace Jhoule\Mailshake\Requests\Activity;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Lead;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\HasCampaign;
use Jhoule\Mailshake\Traits\HasRecipient;

class LeadStatusChanges extends MailshakeRequest
{
    use HasRecipient;
    use HasCampaign;
    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.activity.lead-status-changes');

        parent::__construct();
    }

    /**
     * Obtains the most recently updated leads. A lead can be closed, ignored, opened,
     * or reopened. A reopened lead has open as its status, it’s just that at one
     * point that lead had been ignored or closed.
     *
     * @param int|null    $campaignID             Restrict to a single campaign.
     * @param string|null $recipientEmailAddress  Limit to specific recipients.
     * @param string|null $assignedToEmailAddress Only get leads that are assigned to this person on your team.
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
        string $recipientEmailAddress = null,
        string $assignedToEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ): Collection {
        $response = $this->sendRequest([
            'campaignID'             => $campaignID,
            'recipientEmailAddress'  => $recipientEmailAddress,
            'assignedToEmailAddress' => $assignedToEmailAddress,
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
