<?php

namespace Jhoule\Mailshake\Requests\Activity;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\TransformsOpens;

class Opens extends MailshakeRequest
{
    use TransformsOpens;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.activity.opens');

        parent::__construct();
    }

    /**
     * Obtains the most recent emails opened.
     *
     * @param int|null $campaignID Restrict to a single campaign.
     * @param int|null $campaignMessageID Restrict to a single message within a campaign.
     * @param bool $excludeDuplicates If true this will only not return data when recipients open the same email more than once.
     * @param string|null $recipientEmailAddress Limit to specific recipients.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public function get(
        int $campaignID = null,
        int $campaignMessageID = null,
        bool $excludeDuplicates = false,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $response = $this->sendRequest([
            'campaignID' => $campaignID,
            'campaignMessageID' => $campaignMessageID,
            'excludeDuplicates' => $excludeDuplicates,
            'recipientEmailAddress' => $recipientEmailAddress,
            'nextToken' => $nextToken,
            'perPage' => $perPage
        ]);

        return collect([
            'nextToken' => $response->nextToken,
            'opens' => $this->transformOpens($response->results),
        ]);
    }

}
