<?php

namespace Jhoule\Mailshake\Requests\Campaigns;

use Jhoule\Mailshake\Models\CampaignExport;
use Jhoule\Mailshake\Requests\MailshakeRequest;

class ExportStatus extends MailshakeRequest
{
    public function __construct()
    {
        $this->endpoint = config('mailshake.endpoints.campaign.export-status');

        parent::__construct();
    }

    /**
     * Exporting campaigns is an asynchronous process, so this endpoint lets
     * you check on how things are going. If isFinished is true, then the
     * export has completed. The csvDownloadUrl field provides the csv
     * file you can download.
     *
     * @param int $statusID
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jhoule\Mailshake\Errors\InternalError
     * @throws \Jhoule\Mailshake\Errors\NotFound
     * @throws \Jhoule\Mailshake\Errors\MissingParameter
     *
     * @return CampaignExport
     */
    public function get(int $statusID): CampaignExport
    {
        $response = $this->sendRequest(['statusID' => $statusID]);

        return new CampaignExport([
            'isFinished'     => $response->isFinished,
            'csvDownloadUrl' => $response->csvDownloadUrl,
        ]);
    }
}
