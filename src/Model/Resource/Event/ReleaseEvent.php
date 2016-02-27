<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class ReleaseEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just released ' . $this->payload['release']['name'] . ' of ' . $this->repo->name;
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'release' => $this->payload['release']['name']
        ];
    }
}
