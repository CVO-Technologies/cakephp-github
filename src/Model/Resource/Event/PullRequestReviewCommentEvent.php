<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event;

use CvoTechnologies\GitHub\Model\Resource\Event;

class PullRequestReviewCommentEvent extends Event
{
    public function describe()
    {
        return $this->actor->login . ' just commented on \'' . $this->payload['pull_request']['title'] . '\' (' . $this->repo->name . '): ' . $this->payload['comment']['body'];
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'pull_request' => $this->payload['pull_request']['title'],
            'diff_hunk' => $this->payload['comment']['diff_hunk'],
            'body' => $this->payload['comment']['body']
        ];
    }
}
