<?php

namespace Jhoule\Mailshake\Requests\Senders;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\TransformsSender;

class SendersList extends MailshakeRequest
{
    use TransformsSender;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.senders.list');

        parent::__construct();
    }

    /**
     * List all of a team’s senders.
     *
     * @param string|null $search Filters what senders are returned.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public function get(
        string $search = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $response = $this->sendRequest([
            'search' => $search,
            'nextToken' => $nextToken,
            'perPage' => $perPage,
        ]);

        $senders = new Collection();
        foreach($response->results as $sender) {
            $senders->push($this->transformSender($sender));
        }

        $result = ['senders' => $senders];
        if(property_exists($response, 'nextToken')) {
            $result['nextToken'] = $response->nextToken;
        }

        return collect($result);
    }

}
