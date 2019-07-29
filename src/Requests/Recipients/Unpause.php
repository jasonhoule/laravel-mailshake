<?php

namespace Jhoule\Mailshake\Requests\Recipients;

use Jhoule\Mailshake\Models\Recipient;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class Unpause extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.recipients.unpause');

        parent::__construct();
    }

    /**
     * Resumes sending for a recipient. This team’s sending calendar will reschedule itself
     * to account for this recipient’s pending emails. In rare cases it may take up to 5
     * minutes for the calendar to show updated scheduled times.
     *
     * A not_found error will be returned if the recipient could not be found or is not paused.
     *
     * @param int $campaignID The campaign to unpause.
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
            'isPaused' => $response->isPaused,
            'first' => $response->first,
            'last' => $response->last,
            'fields' => $response->fields,
        ]);
    }

}
