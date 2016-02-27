<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class IssueCommentEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just commented on \'' . $this->payload['issue']['title'] . '\' (' . $this->repo->name . '): ' . $this->payload['comment']['body'];
    }

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
