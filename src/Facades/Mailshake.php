<?php

namespace Jhoule\Mailshake\Facades;

use Illuminate\Support\Facades\Facade;
use Jhoule\Mailshake\Me;

class Mailshake extends Facade
{

    public static function me()
    {
        $me = new Me();
        return $me->get();
    }

}
