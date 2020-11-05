<?php

namespace Jhoule\Mailshake\Requests\Campaigns;

use Jhoule\Mailshake\Models\Campaign;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\TransformsMessages;
use Jhoule\Mailshake\Traits\TransformsSender;

class Get extends MailshakeRequest
{
    use TransformsMessages;
    use TransformsSender;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.campaign.get');

        parent::__construct();
    }

    /**
     * Retrieves a single campaign and its message sequence. A not_found
     * error will be returned if the campaign could not be found.
     *
     * @param int $campaignID
     *
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     *
     * @return Campaign
     */
    public function get(int $campaignID): Campaign
    {
        $response = $this->sendRequest(['campaignID' => $campaignID]);

        return new Campaign([
            'id'       => $response->id,
            'title'    => $response->title,
            'created'  => $response->created,
            'isArchived' => $response->isArchived,
            'isPaused' => $response->isPaused,
            'messages' => $this->transformMessages($response->messages),
            'sender'   => isset($response->sender) ? $this->transformSender($response->sender) : null,
            'url'      => $response->url,
        ]);
    }
}
