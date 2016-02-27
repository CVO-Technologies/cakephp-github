<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class PushEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just pushed ' . $this->payload['size'] . ' commits to ' . $this->repo->name;
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'size' => $this->payload['size'],
            'ref' => $this->payload['ref']
        ];
    }
}
