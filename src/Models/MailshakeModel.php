<?php

namespace Jhoule\Mailshake\Models;

class MailshakeModel
{
    public function __construct(array $properties = [])
    {
        $this->fill($properties);
    }

    public function fill(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
