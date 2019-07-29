<?php

namespace Jhoule\Mailshake\Requests\Campaigns;

use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Models\Campaign;
use Jhoule\Mailshake\Traits\TransformsMessages;
use Jhoule\Mailshake\Traits\TransformsSender;

class Create extends MailshakeRequest
{
    use TransformsMessages, TransformsSender;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.campaign.create');
        parent::__construct();
    }

    /**
     * Creates a new campaign. This campaign cannot be sent until the user
     * finishes the wizard in Mailshake’s user interface, but you can add
     * recipients.
     *
     * @param string|null $title
     * @param string|null $senderID
     * @return Campaign
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public function get(string $title = null, string $senderID = null) : Campaign
    {
        $response = $this->sendRequest(['title' => $title, 'senderID' => $senderID]);

        $campaign =  new Campaign([
            'id' => $response->id,
            'title' => $response->title,
            'created' => $response->created,
            'archived' => $response->archived,
            'isPaused' => $response->isPaused,
            'url' => $response->url,
        ]);

        if(property_exists($response, 'messages')) {
            $campaign->messages = $this->transformMessages($response->messages);
        }

        if(property_exists($response, 'sender')) {
            $campaign->sender = $this->transformSender($response->sender);
        }

        return $campaign;
    }

}
