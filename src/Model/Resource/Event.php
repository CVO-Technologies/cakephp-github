<?php

namespace CvoTechnologies\GitHub\Model\Resource;

use Muffin\Webservice\Model\Resource;

/**
 * @property \CvoTechnologies\GitHub\Model\Resource\User $actor
 */
class Event extends Resource
{
    /**
     * Return a text description of a event.
     *
     * @return string description of a event.
     */
    public function describe()
    {
        var_dump($this);
        var_dump($this->type);

        return $this->id . ' - ' . $this->type . ' - ' . $this->actor->login;
    }

    /**
     * Return event debug information.
     *
     * @return array Debug information
     */
    public function __debugInfo()
    {
        return [
            'actor' => $this->actor->login,
            'repo' => $this->repo->name,
            'payload' => $this->payload
        ];
    }
}
