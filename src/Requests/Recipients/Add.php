<?php

namespace Jhoule\Mailshake\Requests\Recipients;

use Jhoule\Mailshake\Models\AddRecipientRequest;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class Add extends MailshakeRequest
{

    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.recipients.add');

        parent::__construct();
    }

    /**
     * Adds new recipients to a campaign. Each campaign can hold up to 5,000 recipients.
     *
     * If you pass along a full name for your recipients, Mailshake will automatically
     * prepare first, last, and name (full name) as text replacements. If you only
     * have a first name, use that value as their full name.
     *
     * Any other fields you provide (like favorite_color) can be used as text replacements
     * within your campaign. If a text replacement isn’t found, that recipient’s emails
     * will not be scheduled until you make corrections.
     *
     * @param int $campaignID The campaign to add these recipients to.
     * @param bool $addAsNewList Pass true to keep these recipients grouped together.
     * @param bool $truncateExtraFields Mailshake limits you to 30 recipient fields. If true then truncate.
     * @param string|null $listOfEmails A comma or newline separated list of email addresses to add.
     * @param array|null $addresses A structured list of recipient data that can include custom fields.
     * @param array|null $csvData A structured object representing a spreadsheet of comma-separated recipient data.
     * @return AddRecipientRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public function get(
        int $campaignID,
        bool $addAsNewList = false,
        bool $truncateExtraFields = false,
        string $listOfEmails = null,
        array $addresses = null,
        array $csvData = null) : AddRecipientRequest
    {
        $response = $this->sendRequest([
            'campaignID' => $campaignID,
            'addAsNewList' => $addAsNewList,
            'truncateExtraFields' => $truncateExtraFields,
            'listOfEmails' => $listOfEmails,
            'addresses' => $addresses,
            'csvData' => $csvData,
        ]);

        return new AddRecipientRequest([
            'invalidEmails' => $response->invalidEmails,
            'isEmpty' => $response->isEmpty,
            'addingToBatchID' => $response->addingToBatchID,
            'checkStatusID' => $response->checkStatusID,
        ]);
    }

}
