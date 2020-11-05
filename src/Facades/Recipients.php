<?php

namespace Jhoule\Mailshake\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jhoule\Mailshake\Filters\RecipientFilterOptions;
use Jhoule\Mailshake\Models\AddedRecipients;
use Jhoule\Mailshake\Models\AddRecipientRequest;
use Jhoule\Mailshake\Models\Recipient;
use Jhoule\Mailshake\Requests\Recipients\Add;
use Jhoule\Mailshake\Requests\Recipients\AddStatus;
use Jhoule\Mailshake\Requests\Recipients\Get;
use Jhoule\Mailshake\Requests\Recipients\Pause;
use Jhoule\Mailshake\Requests\Recipients\RecipientsList;
use Jhoule\Mailshake\Requests\Recipients\Unpause;
use Jhoule\Mailshake\Requests\Recipients\Unsubscribe;

class Recipients extends Facade
{
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
     * @param int         $campaignID          The campaign to add these recipients to.
     * @param bool        $addAsNewList        Pass true to keep these recipients grouped together.
     * @param bool        $truncateExtraFields Mailshake limits you to 30 recipient fields. If true then truncate.
     * @param string|null $listOfEmails        A comma or newline separated list of email addresses to add.
     * @param array|null  $addresses           A structured list of recipient data that can include custom fields.
     * @param array|null  $csvData             A structured object representing a spreadsheet of comma-separated recipient data.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return AddRecipientRequest
     */
    public static function add(
        int $campaignID,
        bool $addAsNewList = false,
        bool $truncateExtraFields = false,
        string $listOfEmails = null,
        array $addresses = null,
        array $csvData = null
    ): AddRecipientRequest {
        $request = new Add();

        return $request->get($campaignID, $addAsNewList, $truncateExtraFields, $listOfEmails, $addresses, $csvData);
    }

    /**
     * Adding recipients is an asynchronous process, so this endpoint lets you check on how
     * things are going. If isFinished is true, then the import has completed. The problems
     * field will let you determine the exact success or failure of the import.
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
    public static function addStatus(int $statusID): AddedRecipients
    {
        $request = new AddStatus();

        return $request->get($statusID);
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
    public static function get(int $recipientID = null, int $campaignID = null, string $emailAddress = null): Recipient
    {
        $request = new Get();

        return $request->get($recipientID, $campaignID, $emailAddress);
    }

    /**
     * Lists all of the recipients in a campaign. You can use this endpoint to
     * search recipients, filter by activity, or find recipients who have some
     * of kind of problem (like a missing text replacement or an email that
     * failed to send).
     *
     * @param int                         $campaignID The campaign to look in.
     * @param RecipientFilterOptions|null $filter     Criteria to filter recipients with.
     * @param string|null                 $search     Filters what recipients are returned.
     * @param string|null                 $nextToken  Fetches the next page from a previous request.
     * @param int|null                    $perPage    How many results to get at once, up to 100.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return Collection
     */
    public static function list(
        int $campaignID,
        RecipientFilterOptions $filter = null,
        string $search = null,
        string $nextToken = null,
        int $perPage = null
    ): Collection {
        $request = new RecipientsList();

        return $request->get($campaignID, $filter, $search, $nextToken, $perPage);
    }

    /**
     * Immediately pauses all sending for a single recipient. If any emails for recipient
     * are currently being sent they will not be stopped.
     *
     * A not_found error will be returned if the recipient could not be found.
     *
     * @param int    $campaignID   The campaign that this recipient belongs to.
     * @param string $emailAddress The address of the recipient.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return Recipient
     */
    public static function pause(int $campaignID, string $emailAddress): Recipient
    {
        $request = new Pause();

        return $request->get($campaignID, $emailAddress);
    }

    /**
     * Resumes sending for a recipient. This team’s sending calendar will reschedule itself
     * to account for this recipient’s pending emails. In rare cases it may take up to 5
     * minutes for the calendar to show updated scheduled times.
     *
     * A not_found error will be returned if the recipient could not be found or is not paused.
     *
     * @param int    $campaignID   The campaign to unpause.
     * @param string $emailAddress The address of the recipient.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return Recipient
     */
    public static function unpause(int $campaignID, string $emailAddress): Recipient
    {
        $request = new Unpause();

        return $request->get($campaignID, $emailAddress);
    }

    /**
     * Adds a list of email addresses to your unsubscribe list.
     *
     * @param array $emailAddresses A comma-separated list of email addresses to unsubscribe.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return bool Returns true if successful
     */
    public static function unsubscribe(array $emailAddresses): bool
    {
        $request = new Unsubscribe();

        return $request->get($emailAddresses);
    }
}
