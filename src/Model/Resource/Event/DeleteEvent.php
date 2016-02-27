<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class DeleteEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just deleted ' . $this->payload['ref_type'] . ' ' . $this->payload['ref'] . ' from ' . $this->repo->name;
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'ref_type' => $this->payload['ref_type'],
            'ref' => $this->payload['ref']
        ];
    }
}
