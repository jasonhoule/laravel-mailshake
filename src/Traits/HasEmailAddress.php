<?php

namespace Jhoule\Mailshake\Traits;

use Jhoule\Mailshake\Models\EmailAddress;

trait HasEmailAddress
{
    private function getEmailAddress($address): EmailAddress
    {
        return new EmailAddress([
            'address'  => $address->address,
            'fullName' => $address->fullName,
            'first'    => $address->first,
            'last'     => $address->last,
        ]);
    }
}
