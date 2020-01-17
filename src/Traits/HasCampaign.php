<?php

namespace Jhoule\Mailshake\Traits;

use Jhoule\Mailshake\Models\Campaign;

trait HasCampaign
{
    private function getCampaign($campaignData): Campaign
    {
        return new Campaign([
            'id'    => $campaignData->id,
            'title' => $campaignData->title,
        ]);
    }
}
