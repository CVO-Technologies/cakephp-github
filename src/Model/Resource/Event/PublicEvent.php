<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class PublicEvent extends Event
{
    /**
     * {@inheritDoc}
     */
    public function describe()
    {
        return $this->actor->login . ' just open-sourced ' . $this->repo->name;
    }

    /**
     * {@inheritDoc}
     */
    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
        ];
    }
}
