<?php

namespace Jhoule\Mailshake\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jhoule\Mailshake\Models\CreatedLeads;
use Jhoule\Mailshake\Models\Lead;
use Jhoule\Mailshake\Models\LeadStatus;
use Jhoule\Mailshake\Requests\Leads\Close;
use Jhoule\Mailshake\Requests\Leads\Create;
use Jhoule\Mailshake\Requests\Leads\Get;
use Jhoule\Mailshake\Requests\Leads\Ignore;
use Jhoule\Mailshake\Requests\Leads\LeadsList;
use Jhoule\Mailshake\Requests\Leads\Reopen;

class Leads extends Facade
{

    /**
     * Marks a lead as “Won” (or “Lost” if you send in that status). The alternative
     * to these states is “Ignored” which means that the lead wasn’t worth pursuing.
     *
     * @param int|null $campaignID If emailAddress is passed without campaignID, we will use your latest campaign.
     * @param string|null $emailAddress The email address of a recipient in this campaign.
     * @param int|null $recipientID The ID of the recipient that this lead refers to.
     * @param int|null $leadID The ID of the lead.
     * @param string|null $status Can be set to “closed” or “lost”.
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function close(
        int $campaignID = null,
        string $emailAddress = null,
        int $recipientID = null,
        int $leadID = null,
        string $status = null
    ) : bool
    {
        $request = new Close();
        return $request->get($campaignID, $emailAddress, $recipientID, $leadID, $status);
    }

    /**
     * Creates one or more leads from recipients of a campaign. You can either pass
     * in the IDs of recipients or if it’s easier, you can pass their email
     * addresses instead. If a recipient was already a lead and was won,
     * this will reopen them as a lead.
     *
     * @param int|null $campaignID
     * @param array|null $emailAddresses
     * @param int|null $recipientIDs
     * @return CreatedLeads
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function create(
        int $campaignID = null,
        array $emailAddresses = null,
        int $recipientIDs = null
    ) : CreatedLeads
    {
        $request = new Create();
        return $request->get($campaignID, $emailAddresses, $recipientIDs);
    }

    /**
     * Gets a single lead. A not_found error will be returned if the lead could not be found.
     *
     * @param int|null $leadID The ID of a lead.
     * @param int|null $recipientID The ID of the recipient that this lead is for.
     * @param int|null $campaignID The campaign that this recipient belongs to. Required if emailAddress is specified.
     * @param string|null $emailAddress The address of the recipient.
     * @return Lead
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function get(
        int $leadID = null,
        int $recipientID = null,
        int $campaignID = null,
        string $emailAddress = null
    ) : Lead
    {
        $request = new Get();
        return $request->get($leadID, $recipientID, $campaignID, $emailAddress);
    }

    /**
     * Marks a lead as “ignored” when means the lead wasn’t worth pursuing. Use
     * Close and pass lost as the status to indicate you worked on this lead
     * but it didn’t pan out.
     *
     * @param int|null $campaignID If emailAddress is passed without campaignID, we will use your latest campaign.
     * @param string|null $emailAddress The email address of a recipient in this campaign.
     * @param int|null $recipientID The ID of the recipient that this lead refers to.
     * @param int|null $leadID The ID of the lead.
     * @return LeadStatus
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function ignore(
        int $campaignID = null,
        string $emailAddress = null,
        int $recipientID = null,
        int $leadID = null
    ) : LeadStatus
    {
        $request = new Ignore();
        return $request->get($campaignID, $emailAddress, $recipientID, $leadID);
    }

    /**
     * Lists your leads. You can use this endpoint to search leads, filter
     * by status, or find leads assigned to one of your teammates.
     *
     * @param int|null $campaignID Filter leads to the ones from this campaign.
     * @param string|null $status Filter to leads in a particular status.
     * @param string|null $assignedToEmailAddress Leads assigned to this teammate.
     * @param string|null $search Filters what leads are returned.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function list(
        int $campaignID = null,
        string $status = null,
        string $assignedToEmailAddress = null,
        string $search = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new LeadsList();
        return $request->get($campaignID, $status, $assignedToEmailAddress, $search, $nextToken, $perPage);
    }

    /**
     * Takes a closed or ignored lead and makes it open again and available for review.
     *
     * @param int|null $campaignID If emailAddress is passed without campaignID, we will use your latest campaign.
     * @param string|null $emailAddress The email address of a recipient in this campaign.
     * @param int|null $recipientID The ID of the recipient that this lead refers to.
     * @param int|null $leadID The ID of the lead.
     * @return LeadStatus
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function reopen(
        int $campaignID = null,
        string $emailAddress = null,
        int $recipientID = null,
        int $leadID = null
    ) : LeadStatus
    {
        $request = new Reopen();
        return $request->get($campaignID, $emailAddress, $recipientID, $leadID);
    }
}
