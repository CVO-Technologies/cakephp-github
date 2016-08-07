<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class IssuesEvent extends Event
{
    /**
     * {@inheritDoc}
     */
    public function describe()
    {
        return $this->actor->login . ' just created an issue on ' . $this->repo->name . ': ' . $this->payload['issue']['title'];
    }

    /**
     * {@inheritDoc}
     */
    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'issue' => $this->payload['issue']['title'],
            'body' => $this->payload['issue']['body']
        ];
    }
}
