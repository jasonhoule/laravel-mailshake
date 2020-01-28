<?php

namespace Jhoule\Mailshake\Traits;

use Illuminate\Support\Collection;
use Jhoule\Mailshake\Models\Open;
use Jhoule\Mailshake\Models\SentMessage;

trait TransformsOpens
{
    use HasRecipient;
    use HasCampaign;
    use HasMessage;

    private function transformOpens($openData): Collection
    {
        $opens = new Collection();
        foreach ($openData as $open) {
            $opens->push(new Open([
                'id'          => $open->id,
                'actionDate'  => $open->actionDate,
                'isDuplicate' => $open->isDuplicate,
                'recipient'   => $this->getRecipient($open->recipient),
                'campaign'    => $this->getCampaign($open->campaign),
                'parent'      => new SentMessage([
                    'id'      => $open->parent->id,
                    'type'    => $open->parent->type,
                    'message' => $this->getMessage($open->parent->message),
                ]),
            ]));
        }

        return $opens;
    }
}
