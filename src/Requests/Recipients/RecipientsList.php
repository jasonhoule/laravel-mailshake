<?php

namespace Jhoule\Mailshake\Requests\Recipients;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Filters\RecipientFilterOptions;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\TransformsRecipients;

class RecipientsList extends MailshakeRequest
{
    use TransformsRecipients;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.recipients.list');

        parent::__construct();
    }

    /**
     * Lists all of the recipients in a campaign. You can use this endpoint to
     * search recipients, filter by activity, or find recipients who have some
     * of kind of problem (like a missing text replacement or an email that
     * failed to send).
     *
     * @param int $campaignID The campaign to look in.
     * @param RecipientFilterOptions|null $filter Criteria to filter recipients with.
     * @param string|null $search Filters what recipients are returned.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int|null $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public function get(
        int $campaignID,
        RecipientFilterOptions $filter = null,
        string $search = null,
        string $nextToken = null,
        int $perPage = null) : Collection
    {
        $parameters = [
            'campaignID' => $campaignID,
            'search' => $search,
            'nextToken' => $nextToken,
            'perPage' => $perPage
        ];

        if(!empty($filter)) {
            $parameters['filter'] = $filter->getOptions();
        }

        $response = $this->sendRequest($parameters);

        return collect([
            'nextToken' =>  $response->nextToken ?? null,
            'recipients' => $this->transformRecipients($response->results)
        ]);
    }
}
