<?php

namespace CvoTechnologies\GitHub\Webservice\Driver;

use Cake\Network\Http\Client;
use Muffin\Webservice\AbstractDriver;

class GitHub extends AbstractDriver
{

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        $this->client(new Client([
            'host' => 'api.github.com',
            'scheme' => 'https',
        ]));
    }
}
