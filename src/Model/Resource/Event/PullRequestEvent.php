<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class PullRequestEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just opened a pull request on ' . $this->repo->name . ': ' . $this->payload['pull_request']['title'];
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'pull_request' => $this->payload['pull_request']['title'],
            'body' => $this->payload['pull_request']['body']
        ];
    }
}
