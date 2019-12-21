<?php

namespace CvoTechnologies\GitHub\Webservice\Driver;

use Cake\Http\Client;
use Muffin\Webservice\AbstractDriver;

/**
 * Class GitHub
 *
 * @method Client client() client(Client $client = null)
 *
 * @package CvoTechnologies\GitHub\Webservice\Driver
 */
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
