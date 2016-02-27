<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class GollumEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just worked on a wiki page of ' . $this->repo->name;
    }
}
