<?php

namespace Jhoule\Mailshake\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jhoule\Mailshake\Requests\Activity\Clicks;
use Jhoule\Mailshake\Requests\Activity\CreatedLeads;
use Jhoule\Mailshake\Requests\Activity\LeadStatusChanges;
use Jhoule\Mailshake\Requests\Activity\Opens;
use Jhoule\Mailshake\Requests\Activity\Replies;
use Jhoule\Mailshake\Requests\Activity\Sent;

class Activity extends Facade
{

    /**
     * Obtains the most recent links clicked.
     *
     * @param int|null $campaignID Restrict to a single campaign.
     * @param bool $excludeDuplicates If true this will only not return data when recipients click the same link more than once.
     * @param bool|null $matchUrl An exact matching of a specific link you’re tracking.
     * @param string|null $recipientEmailAddress Limit to specific recipients.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public static function clicks(
        int $campaignID = null,
        bool $excludeDuplicates = false,
        bool $matchUrl = null,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new Clicks();
        return $request->get($campaignID, $excludeDuplicates, $matchUrl, $recipientEmailAddress, $nextToken, $perPage);
    }

    /**
     * Obtains the most recently created leads. Usually leads are automatically created from
     * the rules you’ve set up in Lead Catcher, but Mailshake users can also manually turn
     * recipients into leads.
     *
     * @param int|null $campaignID Restrict to a single campaign.
     * @param string|null $recipientEmailAddress Limit to specific recipients.
     * @param string|null $assignedToEmailAddress Only get leads that are assigned to this person on your team.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public static function createdLeads(
        int $campaignID = null,
        string $recipientEmailAddress = null,
        string $assignedToEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new CreatedLeads();
        return $request->get($campaignID, $recipientEmailAddress, $assignedToEmailAddress, $nextToken, $perPage);
    }

    /**
     * Obtains the most recently updated leads. A lead can be closed, ignored, opened,
     * or reopened. A reopened lead has open as its status, it’s just that at one
     * point that lead had been ignored or closed.
     *
     * @param int|null $campaignID Restrict to a single campaign.
     * @param string|null $recipientEmailAddress Limit to specific recipients.
     * @param string|null $assignedToEmailAddress Only get leads that are assigned to this person on your team.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public static function leadStatusChanges(
        int $campaignID = null,
        string $recipientEmailAddress = null,
        string $assignedToEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new LeadStatusChanges();
        return $request->get(
            $campaignID,
            $recipientEmailAddress,
            $assignedToEmailAddress,
            $nextToken,
            $perPage
        );
    }

    /**
     * Obtains the most recent emails opened.
     *
     * @param int|null $campaignID Restrict to a single campaign.
     * @param int|null $campaignMessageID Restrict to a single message within a campaign.
     * @param bool $excludeDuplicates If true this will only not return data when recipients open the same email more than once.
     * @param string|null $recipientEmailAddress Limit to specific recipients.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public static function opens(
        int $campaignID = null,
        int $campaignMessageID = null,
        bool $excludeDuplicates = false,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new Opens();
        return $request->get(
            $campaignID,
            $campaignMessageID,
            $excludeDuplicates,
            $recipientEmailAddress,
            $nextToken,
            $perPage
        );
    }

    /**
     * Obtains the most recent replies to your sent emails. Pay special attention to
     * replyType because you can use this endpoint to look at bounces, out-of-office
     * replies, etc.
     *
     * @param string|null $replyType Filter to only reply, bounce, out-of-office, unsubscribe or delay-notification replies.
     * @param int|null $campaignID Restrict to a single campaign.
     * @param string|null $recipientEmailAddress Limit to specific recipients.
     * @param string|null $nextToken Fetches the next page from a previous request.
     * @param int $perPage How many results to get at once, up to 100.
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     */
    public static function replies(
        string $replyType = null,
        int $campaignID = null,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new Replies();
        return $request->get(
            $replyType,
            $campaignID,
            $recipientEmailAddress,
            $nextToken,
            $perPage
        );
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
    public static function sent(
        string $messageType = null,
        string $campaignMessageType = null,
        int $campaignID = null,
        int $campaignMessageID = null,
        string $recipientEmailAddress = null,
        string $nextToken = null,
        int $perPage = 100
    ) : Collection
    {
        $request = new Sent();
        return $request->get(
            $messageType,
            $campaignMessageType,
            $campaignID,
            $campaignMessageID,
            $recipientEmailAddress,
            $nextToken,
            $perPage
        );
    }
}
