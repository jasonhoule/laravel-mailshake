<?php

namespace Jhoule\Mailshake\Requests\Activity;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\TransformsSentMessages;

class Sent extends MailshakeRequest
{
    use TransformsSentMessages;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.activity.sent');

        parent::__construct();
    }

    /**
     * Obtains the most recent emails you have sent. In most cases you’ll want to
     * look at campaign-based emails, but this endpoint also lets you get one-off
     * replies you’ve sent within Mailshake via Lead Catcher.
     *
     * @param string|null $messageType If specified, you can filter to only one-off or campaign messages.
     * @param string|null $campaignMessageType Filter to a specific type of message within a campaign (see MessageType)
     * @param int|null $campaignID Restrict to a single campaign.
     * @param int|null $campaignMessageID Restrict to a single message within a campaign.
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
        string $messageType = null,
        string $campaignMessageType = null,
        int $campaignID = null,
        int $campaignMessageID = null,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $response = $this->sendRequest([
            'messageType' => $messageType,
            'campaignMessageType' => $campaignMessageType,
            'campaignID' => $campaignID,
            'campaignMessageID' => $campaignMessageID,
            'recipientEmailAddress' => $recipientEmailAddress,
            'nextToken' => $nextToken,
            'perPage' => $perPage
        ]);

        return collect([
            'nextToken' => $response->nextToken,
            'sentMessages' => $this->transformSentMessages($response->results),
        ]);
    }
}
