<?php

namespace Jhoule\Mailshake\Filters;

class RecipientFilterOptions
{
    public $action;
    public $negateAction;
    public $campaignMessageID;

    public function __construct(string $action, bool $negateAction = false, int $campaignMessageID = null)
    {
        $this->action = $action;
        $this->negateAction = $negateAction;
        $this->campaignMessageID = $campaignMessageID;
    }

    public function getOptions() : array
    {
        return [
            'action'            => $this->action,
            'negateAction'      => $this->negateAction,
            'campaignMessageID' => $this->campaignMessageID,
        ];
    }
}
