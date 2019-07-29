<?php

namespace Jhoule\Mailshake\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jhoule\Mailshake\Models\CampaignExport;
use Jhoule\Mailshake\Models\CampaignExportRequest;
use Jhoule\Mailshake\Requests\Campaigns\CampaignList;
use Jhoule\Mailshake\Requests\Campaigns\Create;
use Jhoule\Mailshake\Requests\Campaigns\Export;
use Jhoule\Mailshake\Requests\Campaigns\ExportStatus;
use Jhoule\Mailshake\Requests\Campaigns\Get;
use Jhoule\Mailshake\Models\Campaign as CampaignModel;
use Jhoule\Mailshake\Requests\Campaigns\Pause;
use Jhoule\Mailshake\Requests\Campaigns\Unpause;

class Campaign extends Facade
{

    /**
     * Creates a new campaign. This campaign cannot be sent until the user
     * finishes the wizard in Mailshake’s user interface, but you can add
     * recipients.
     *
     * @param string|null $title
     * @param string|null $senderID
     * @return CampaignModel
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function create(string $title = null, string $senderID = null) : CampaignModel
    {
        $campaign = new Create();
        return $campaign->get($title, $senderID);
    }

    /**
     * Asynchronously starts an export of one or more campaigns to CSV format.
     * All campaign data will be included in a single csv file you can download.
     *
     * @param int $campaignID
     * @param string $exportType
     * @param string|null $timezone
     * @return CampaignExportRequest
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function export(int $campaignID, string $exportType, string $timezone = null) : CampaignExportRequest
    {
        $export = new Export();
        return $export->get($campaignID, $exportType, $timezone);
    }

    /**
     * Exporting campaigns is an asynchronous process, so this endpoint
     * lets you check on how things are going. If isFinished is
     * true, then the export has completed. The csvDownloadUrl f
     * ield provides the csv file you can download.
     *
     * @param int $statusID
     * @return CampaignExport
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function exportStatus(int $statusID) : CampaignExport
    {
        $status = new ExportStatus();
        return $status->get($statusID);
    }

    /**
     * Retrieves a single campaign and its message sequence. A not_found
     * error will be returned if the campaign could not be found.
     *
     * @param int $campaignID
     * @return CampaignModel
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function get(int $campaignID) : CampaignModel
    {
        $campaign = new Get();
        return $campaign->get($campaignID);
    }

    /**
     * List all of a team’s campaigns.
     *
     * @param string|null $search
     * @param string|null $nextToken
     * @param int|null $perPage
     * @return Collection
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function list(string $search = null, string $nextToken = null, int $perPage = null) : Collection
    {
        $list = new CampaignList();
        return $list->get($search, $nextToken, $perPage);
    }

    /**
     * Immediately pauses all sending for a campaign. If a batch of emails
     * for this campaign is currently being sent they will not be stopped.
     *
     * @param int $campaignID
     * @return bool
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function pause(int $campaignID) : bool
    {
        $pause = new Pause();
        return $pause->get($campaignID);
    }

    /**
     * Resumes sending for a campaign. This team’s sending calendar will reschedule
     * itself to account for this campaign’s pending emails. In rare cases it may
     * take up to 5 minutes for the calendar to show scheduled times for this campaign.
     *
     * @param int $campaignID
     * @return bool
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     */
    public static function unpause(int $campaignID) : bool
    {
        $unpause = new Unpause();
        return $unpause->get($campaignID);
    }

}
