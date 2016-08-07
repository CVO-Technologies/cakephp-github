<?php

namespace CvoTechnologies\GitHub\Model\Resource;

use Muffin\Webservice\Model\Resource;

class Event extends Resource
{
    public function describe()
    {
        var_dump($this);
        var_dump($this->type);

        return $this->id . ' - ' . $this->type . ' - ' . $this->actor->login;
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'payload' => $this->payload
        ];
    }
}
