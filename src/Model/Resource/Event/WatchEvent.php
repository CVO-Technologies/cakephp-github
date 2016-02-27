<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class WatchEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just started watching ' . $this->repo->name;
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
        ];
    }
}
