<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class CreateEvent extends Event
{
    /**
     * {@inheritDoc}
     */
    public function describe()
    {
        return $this->actor->login . ' just created ' . $this->repo->name;
    }
}
