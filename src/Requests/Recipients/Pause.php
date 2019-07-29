<?php

namespace Jhoule\Mailshake\Requests\Recipients;

use Jhoule\Mailshake\Models\Recipient;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class Pause extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.recipients.pause');

        parent::__construct();
    }

    /**
     * Immediately pauses all sending for a single recipient. If any emails for recipient
     * are currently being sent they will not be stopped.
     *
     * A not_found error will be returned if the recipient could not be found.
     *
     * @param int $campaignID The campaign that this recipient belongs to.
     * @param string $emailAddress The address of the recipient.
     * @return Recipient
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public function get(int $campaignID, string $emailAddress) : Recipient
    {
        $response = $this->sendRequest([
            'campaignID' => $campaignID,
            'emailAddress' => $emailAddress
        ]);

        return new Recipient([
            'id' => $response->id,
            'emailAddress' => $response->emailAddress,
            'fullName' => $response->fullName,
            'created' => $response->created ?? null,
            'isPaused' => $response->isPaused,
            'first' => $response->first,
            'last' => $response->last,
            'fields' => $response->fields
        ]);
    }
}
