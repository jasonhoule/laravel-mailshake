<?php

namespace Jhoule\Mailshake\Requests\Activity;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Click;
use Jhoule\Mailshake\Models\SentMessage;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\HasCampaign;
use Jhoule\Mailshake\Traits\HasRecipient;

class Clicks extends MailshakeRequest
{
    use HasRecipient, HasCampaign;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.activity.clicks');

        parent::__construct();
    }

    /**
     * Obtains the most recent links clicked.
     *
     * @param int|null $campaignID Restrict to a single campaign.
     * @param bool $excludeDuplicates If true this will only not return data when recipients click the same link more than once.
     * @param bool|null $matchUrl An exact matching of a specific link you’re tracking.
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
        bool $excludeDuplicates = false,
        bool $matchUrl = null,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $response = $this->sendRequest([
            $campaignID,
            $excludeDuplicates,
            $matchUrl,
            $recipientEmailAddress,
            $nextToken,
            $perPage
        ]);

        $clicks = new Collection();
        foreach($response->results as $each) {
            $clicks->push(new Click([
                'id' => $each->id,
                'link' => $each->link,
                'actionDate' => $each->actionDate,
                'isDuplicate' => $each->isDuplicate,
                'recipient' => $this->getRecipient($each->recipient),
                'campaign' => $this->getCampaign($each->campaign),
                'parent' => new SentMessage([
                    'id' => $each->parent->id,
                    'type' => $each->parent->type,
                    'message' => $each->parent->message
                ]),
            ]));
        }

        return collect(['nextToken' => $response->nextToken, 'clicks' => $clicks]);
    }

}
