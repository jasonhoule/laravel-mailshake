<?php

namespace Jhoule\Mailshake\Requests\Recipients;

use Jhoule\Mailshake\Models\Recipient;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class Get extends MailshakeRequest
{
    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.recipients.get');

        parent::__construct();
    }

    /**
     * Gets a single recipient’s basic information. A not_found error will be
     * returned if the recipient could not be found.
     *
     * @param int|null    $recipientID  The ID of a recipient.
     * @param int|null    $campaignID   The campaign that this recipient belongs to. Required if emailAddress is specified.
     * @param string|null $emailAddress The address of the recipient.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return Recipient
     */
    public function get(int $recipientID = null, int $campaignID = null, string $emailAddress = null) : Recipient
    {
        $response = $this->sendRequest([
            'recipientID'  => $recipientID,
            'campaignID'   => $campaignID,
            'emailAddress' => $emailAddress,
        ]);

        return new Recipient([
            'id'           => $response->id,
            'emailAddress' => $response->emailAddress,
            'fullName'     => $response->fullName,
            'created'      => $response->created,
            'isPaused'     => $response->isPaused,
            'first'        => $response->first,
            'last'         => $response->last,
            'fields'       => $response->fields,
        ]);
    }
}
