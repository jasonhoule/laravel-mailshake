<?php

namespace Jhoule\Mailshake\Requests\Campaigns;

use Jhoule\Mailshake\Models\CampaignExportRequest;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class Export extends MailshakeRequest
{
    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.campaign.export');

        parent::__construct();
    }

    /**
     * Asynchronously starts an export of one or more campaigns to CSV format.
     * All campaign data will be included in a single csv file you can download.
     *
     * @param int         $campaignID
     * @param string      $exportType
     * @param string|null $timezone
     *
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     * @throws \Jhoule\Mailshake\Errors\NotFound
     *
     * @return CampaignExportRequest
     */
    public function get(int $campaignID, string $exportType, string $timezone = null) : CampaignExportRequest
    {
        $response = $this->sendRequest([
            'campaignID' => $campaignID,
            'exportType' => $exportType,
            'timezone'   => $timezone,
        ]);

        return new CampaignExportRequest([
            'isEmpty'       => $response->isEmpty,
            'checkStatusID' => $response->checkStatusID,
        ]);
    }
}
