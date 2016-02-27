<?php

namespace CvoTechnologies\GitHub\Model\Resource\Event\Member;

use CvoTechnologies\GitHub\Model\Resource\Event\MemberEvent;

class AddedEvent extends MemberEvent
{
    public function describe()
    {
        return $this->actor->login . ' just added ' . $this->payload['member']['login'] . ' as member to ' . $this->repo->name;
    }

    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'user' => $this->payload['member']['login'],
        ];
    }
}
