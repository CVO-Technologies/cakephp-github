<?php

namespace CvoTechnologies\GitHub\Model\Resource;

use Muffin\Webservice\Model\Resource;

class Event extends Resource
{

    public function describe()
    {
        switch ($this->type) {
            case 'CreateEvent':
                return $this->actor->login . ' just created ' . $this->repo->name;
            case 'DeleteEvent':
                return $this->actor->login . ' just deleted ' . $this->repo->name;
            case 'ForkEvent':
                return $this->actor->login . ' just forked ' . $this->repo->name . ' as ' . $this->payload['forkee']['full_name'];
            case 'WatchEvent':
                return $this->actor->login . ' just started watching ' . $this->repo->name;
            case 'PullRequestEvent':
                return $this->actor->login . ' just opened a pull request on ' . $this->repo->name . ': ' . $this->payload['pull_request']['title'];
            case 'IssueCommentEvent':
                return $this->actor->login . ' just commented on \'' . $this->payload['issue']['title'] . '\' (' . $this->repo->name . '): ' . $this->payload['comment']['body'];
        }
        var_dump($this);
        var_dump($this->type);

        return $this->id . ' - ' . $this->type . ' - ' . $this->actor->login;
    }
}
