<?php

namespace CvoTechnologies\GitHub\Webservice;

use Cake\Datasource\ResultSetDecorator;
use Cake\Log\Log;
use Cake\Network\Http\Response;
use Muffin\Webservice\Model\Endpoint;
use Muffin\Webservice\Query;

class EventsWebservice extends GitHubWebservice
{

    protected $_lastIds = [];
    protected $_lastEtag;
    protected $_lastPollInterval;

    /**
     * Initialize and add nested resources
     */
    public function initialize()
    {
        parent::initialize();

        $this->addNestedResource('/repos/:owner/:repo/events', [
            'owner',
            'repo'
        ]);
        $this->addNestedResource('/orgs/:org/events', [
            'org',
        ]);
    }

    protected function _executeReadQuery(Query $query, array $options = [])
    {
        if (empty($query->getOptions()['stream'])) {
            return parent::_executeReadQuery($query, $options);
        }

        $url = $this->getBaseUrl();

        $queryParameters = [];
        // Page number has been set, add to query parameters
        if ($query->page()) {
            $queryParameters['page'] = $query->page();
        }

        // Check if this query could be requested using a nested resource.
        if ($nestedResource = $this->nestedResource($query->clause('where'))) {
            $url = $nestedResource;
        }

        $responses = $this->_stream($url, $queryParameters);

        return new ResultSetDecorator($this->_transformStreamResponses($query->endpoint(), $responses));
    }

    protected function _stream($url, $queryParameters)
    {
        while (true) {
            $options = [];
            if ($this->_lastEtag) {
                $options['headers']['If-None-Match'] = $this->_lastEtag;
            }

            /* @var Response $response */
            $response = $this->driver()->client()->get($url, $queryParameters, $options);
            if ((!$response->isOk()) && ($response->statusCode() != 304)) {
                return;
            }

            if ($response->statusCode() != 304) {
                $this->_lastEtag = $response->header('Etag');
                $this->_lastPollInterval = $response->header('X-Poll-Interval');

                foreach ($response->json as $resource) {
                    if (in_array($resource['id'], $this->_lastIds)) {
                        continue;
                    }

                    array_unshift($this->_lastIds, $resource['id']);

                    yield $resource;
                }
                $this->_lastIds = array_splice($this->_lastIds, 0, 30);
            }

            sleep($this->_lastPollInterval);
        }
    }

    /**
     * Transforms streamed responses into resources
     *
     * @param \Muffin\Webservice\Model\Endpoint $endpoint Endpoint to use for resource class
     * @param \Iterator $resources Iterator to get responses from
     * @yield \Muffin\Webservice\Model\Resource Webservice resource
     * @return \Generator Resource generator
     * @throws \Exception HTTP exception
     */
    protected function _transformStreamResponses(Endpoint $endpoint, \Iterator $resources)
    {
        foreach ($resources as $resource) {
            yield $this->_transformResource($endpoint, $resource);
        }
    }
}
