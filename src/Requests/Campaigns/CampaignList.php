<?php

namespace Jhoule\Mailshake\Requests\Campaigns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Jhoule\Mailshake\Models\Campaign;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\TransformsMessages;
use Jhoule\Mailshake\Traits\TransformsSender;

class CampaignList extends MailshakeRequest
{
    use TransformsMessages, TransformsSender;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.campaign.list');
        Log::debug('Campaigns Endpoint: '.$this->baseURL.$this->endpoint);

        parent::__construct();
    }

    /**
     * List all of a team’s campaigns.
     *
     * @param string|null $search
     * @param string|null $nextToken
     * @param int|null    $perPage
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     *
     * @return Collection
     */
    public function get(string $search = null, string $nextToken = null, int $perPage = null) : Collection
    {
        $parameters = ['search' => $search, 'nextToken' => $nextToken, 'perPage' => $perPage];
        Log::debug('Campaign list paramters: '.print_r($parameters, true));

        $response = $this->sendRequest($parameters);

        $campaigns = new Collection();
        foreach ($response->results as $each) {
            $campaigns->push(new Campaign([
                'id'       => $each->id,
                'title'    => $each->title,
                'created'  => $each->created,
                'archived' => $each->archived,
                'isPaused' => $each->isPaused,
                'messages' => $this->transformMessages($each->messages),
                'sender'   => $this->transformSender($each->sender),
                'url'      => $each->url,
            ]));
        }

        $result = ['campaigns' => $campaigns];

        if (property_exists($response, 'nextToken')) {
            $result['nextToken'] = $response->nextToken;
        }

        return collect($result);
    }
}
