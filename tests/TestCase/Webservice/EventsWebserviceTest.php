<?php

namespace CvoTechnologies\GitHub\Test\TestCase\Webservice;

use Cake\Network\Http\Response;
use Cake\TestSuite\TestCase;
use CvoTechnologies\GitHub\Model\Resource\Event\PushEvent;
use CvoTechnologies\GitHub\Model\Resource\Repository;
use CvoTechnologies\GitHub\Model\Resource\User;
use CvoTechnologies\GitHub\Webservice\Driver\GitHub;
use CvoTechnologies\GitHub\Webservice\EventsWebservice;
use CvoTechnologies\GitHub\Webservice\GitHubWebservice;
use CvoTechnologies\StreamEmulation\Emulation\HttpEmulation;
use CvoTechnologies\StreamEmulation\StreamWrapper;
use Muffin\Webservice\Model\Endpoint;
use Muffin\Webservice\Query;

class EventsWebserviceTest extends TestCase
{

    /**
     * @var \CvoTechnologies\GitHub\Webservice\EventsWebservice
     */
    public $webservice;

    public function setUp()
    {
        parent::setUp();

        $this->webservice = new EventsWebservice([
            'driver' => new GitHub([]),
        ]);

        StreamWrapper::overrideWrapper('https');
    }

    public function tearDown()
    {
        parent::tearDown();

        StreamWrapper::restoreWrapper('https');
    }

    /**
     * @dataProvider nestedResourcesDataProvider
     */
    public function testNestedResources($conditions, $expected)
    {
        $this->assertEquals($expected, $this->webservice->nestedResource($conditions));
    }

    public function nestedResourcesDataProvider()
    {
        return [
            [
                ['owner' => 'cakephp', 'repo' => 'cakephp'], '/repos/cakephp/cakephp/events',
                ['org' => 'cvo-technologies'], '/orgs/cvo-technologies/events',
                ['user' => 'Marlinc'], '/users/Marlinc/events',
            ]
        ];
    }

    public function testLookup()
    {
        StreamWrapper::emulate(HttpEmulation::fromCallable(function () {
            return new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(TESTS . 'events.json'));
        }));

        $query = new Query($this->webservice, new Endpoint);
        $query
            ->read()
            ->where([
                'user' => 'Marlinc'
            ]);

        $event = $this->webservice->execute($query)->first();

        $this->assertInstanceOf(PushEvent::class, $event);
        $this->assertInstanceOf(User::class, $event->actor);
        $this->assertInstanceOf(Repository::class, $event->repo);
        $this->assertEquals('Marlinc', $event->actor->login);
        $this->assertEquals('croogo/croogo', $event->repo->name);
    }
}
