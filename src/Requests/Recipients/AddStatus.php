<?php

namespace Jhoule\Mailshake\Requests\Recipients;

use Jhoule\Mailshake\Models\AddedRecipients;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class AddStatus extends MailshakeRequest
{
    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.recipients.add-status');

        parent::__construct();
    }

    /**
     * Adding recipients is an asynchronous process, so this endpoint lets you
     * check on how things are going. If isFinished is true, then the import
     * has completed. The problems field will let you determine the exact
     * success or failure of the import.
     *
     * @param int $statusID
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return AddedRecipients
     */
    public function get(int $statusID) : AddedRecipients
    {
        $response = $this->sendRequest(['statusID' => $statusID]);

        return new AddedRecipients([
            'isFinished' => $response->isFinished,
            'problems'   => $response->problems,
        ]);
    }
}
