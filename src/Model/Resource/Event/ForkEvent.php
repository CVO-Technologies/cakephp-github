<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class ForkEvent extends Event
{
    /**
     * {@inheritDoc}
     */
    public function describe()
    {
        return $this->actor->login . ' just forked ' . $this->repo->name . ' as ' . $this->payload['forkee']['full_name'];
    }

    /**
     * {@inheritDoc}
     */
    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'fork' => $this->payload['forkee']['full_name'],
        ];
    }
}
