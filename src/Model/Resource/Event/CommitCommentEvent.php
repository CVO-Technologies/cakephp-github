<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class CommitCommentEvent extends Event
{
    /**
     * {@inheritDoc}
     */
    public function describe()
    {
        return $this->actor->login . ' just commented on a commit ' . $this->repo->name . ': ' . $this->payload['comment']['body'];
    }

    /**
     * {@inheritDoc}
     */
    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'commit' => $this->payload['comment']['commit_id'],
            'body' => $this->payload['comment']['body']
        ];
    }
}
