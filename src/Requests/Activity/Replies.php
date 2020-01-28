<?php

namespace Jhoule\Mailshake\Requests\Activity;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Reply;
use Jhoule\Mailshake\Requests\MailshakeRequest;
use Jhoule\Mailshake\Traits\HasCampaign;
use Jhoule\Mailshake\Traits\HasEmailAddress;
use Jhoule\Mailshake\Traits\HasRecipient;
use Jhoule\Mailshake\Traits\HasSentMessage;

class Replies extends MailshakeRequest
{
    use HasRecipient;
    use HasCampaign;
    use HasSentMessage;
    use HasEmailAddress;

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.activity.replies');

        parent::__construct();
    }

    /**
     * Obtains the most recent replies to your sent emails. Pay special attention to
     * replyType because you can use this endpoint to look at bounces, out-of-office
     * replies, etc.
     *
     * @param string|null $replyType             Filter to only reply, bounce, out-of-office, unsubscribe or delay-notification replies.
     * @param int|null    $campaignID            Restrict to a single campaign.
     * @param string|null $recipientEmailAddress Limit to specific recipients.
     * @param string|null $nextToken             Fetches the next page from a previous request.
     * @param int         $perPage               How many results to get at once, up to 100.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return Collection
     */
    public function get(
        string $replyType = null,
        int $campaignID = null,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ): Collection {
        $response = $this->sendRequest([
            'replyType'             => $replyType,
            'campaignID'            => $campaignID,
            'recipientEmailAddress' => $recipientEmailAddress,
            'nextToken'             => $nextToken,
            'perPage'               => $perPage,
        ]);

        $replies = new Collection();
        foreach ($response->results as $each) {
            $replies->push(new Reply([
                'id'                     => $each->id,
                'actionDate'             => $each->actionDate,
                'recipient'              => $this->getRecipient($each->recipient),
                'campaign'               => $this->getCampaign($each->campaign),
                'type'                   => $each->type,
                'parent'                 => $this->getSentMessage($each->parent ?? null),
                'from'                   => $this->getEmailAddress($each->from),
                'subject'                => $each->subject,
                'externalID'             => $each->externalID,
                'externalRawMessageID'   => $each->externalRawMessageID,
                'externalConversationID' => $each->externalConversationID,
                'rawBody'                => $each->rawBody,
                'body'                   => $each->body,
                'plainTextBody'          => $each->plainTextBody,
            ]));
        }

        return collect(['nextToken' => $response->nextToken, 'replies' => $replies]);
    }
}
