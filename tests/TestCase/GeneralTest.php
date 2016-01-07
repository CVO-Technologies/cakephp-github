<?php

namespace CvoTechnologies\GitHub\Test\TestCase;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\ModelAwareTrait;
use Cake\TestSuite\TestCase;

class GeneralTest extends TestCase
{

    use ModelAwareTrait;

    public function setUp()
    {
        parent::setUp();

        ConnectionManager::config('git_hub', [
            'className' => 'Muffin\Webservice\Connection',
            'service' => 'CvoTechnologies/GitHub.GitHub',
        ]);
    }

    public function testEndpoint()
    {
        $this->modelFactory('Endpoint', ['Muffin\Webservice\Model\EndpointRegistry', 'get']);

        $this->loadModel('CvoTechnologies/GitHub.Issues', 'Endpoint');

        $issues = $this->Issues->find()->where([
            'owner' => 'cakephp',
            'repo' => 'cakephp'
        ]);

        $this->assertEquals('issues', $this->Issues->webservice()->endpoint());
        $this->assertInstanceOf('\Muffin\Webservice\Query', $issues);
    }
}
