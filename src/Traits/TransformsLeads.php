<?php

namespace Jhoule\Mailshake\Traits;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Lead;

trait TransformsLeads
{
    private function transformLeads(array $results) : Collection
    {
        $leads = new Collection();
        foreach ($results as $lead) {
            $leads->push(new Lead([
                'recipientID' => $lead->recipientID,
                'leadID'      => $lead->leadID,
            ]));
        }

        return $leads;
    }
}
