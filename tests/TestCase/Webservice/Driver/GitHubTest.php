<?php

namespace CvoTechnologies\GitHub\Test\TestCase\Webservice\Driver;

use Cake\TestSuite\TestCase;
use CvoTechnologies\GitHub\Webservice\Driver\GitHub;

class GitHubTest extends TestCase
{

    /**
     * @var GitHub
     */
    public $driver;

    public function setUp()
    {
        parent::setUp();

        $this->driver = new GitHub([]);
    }

    public function testClient()
    {
        $this->assertInstanceOf('Cake\Network\Http\Client', $this->driver->client());
    }
}
