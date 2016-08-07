<?php

namespace CvoTechnologies\GitHub\Webservice;

use Cake\Datasource\ResultSetDecorator;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Network\Http\Response;
use Cake\Utility\Inflector;
use CvoTechnologies\GitHub\Webservice\Exception\RateLimitExceededException;
use Muffin\Webservice\Model\Endpoint;
use Muffin\Webservice\Query;

class EventsWebservice extends GitHubWebservice
{

    protected $_lastIds = [];
    protected $_lastEtag;
    protected $_lastPollInterval;
    protected $_lastTime;

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
        $this->addNestedResource('/users/:user/events', [
            'user',
        ]);
    }

    protected function _executeReadQuery(Query $query, array $options = [])
    {
        if (empty($query->getOptions()['poll'])) {
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
            $this->_lastTime = time();

            $options = [];
            if ($this->_lastEtag) {
                $options['headers']['If-None-Match'] = $this->_lastEtag;
            }

            /* @var Response $response */
            $response = $this->driver()->client()->get($url, $queryParameters, $options);
            if ((!$response->isOk()) && ($response->statusCode() != 304)) {
                switch ($response->statusCode()) {
                    case 403:
                        if ($response->header('X-Ratelimit-Remaining') == 0) {
                            var_dump($response);
                            throw new RateLimitExceededException([$response->header('X-Ratelimit-Remaining')]);
                        }
                }
                return;
            }

            if ($response->statusCode() != 304) {
                $this->_lastEtag = $response->header('Etag');
                $this->_lastPollInterval = $response->header('X-Poll-Interval');

                $resources = array_reverse($response->json);
                foreach ($resources as $resource) {
                    if (in_array($resource['id'], $this->_lastIds)) {
                        continue;
                    }

                    array_unshift($this->_lastIds, $resource['id']);

                    yield $resource;
                }
                $this->_lastIds = array_splice($this->_lastIds, 0, 30);
            }

            $sleepingTime = $this->_lastPollInterval - (time() - $this->_lastTime);
            if ($sleepingTime > 0) {
                sleep($sleepingTime);
            }
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

    /**
     * Turns a single result into a resource
     *
     * @param array $result
     * @param string $resourceClass
     * @return \Muffin\Webservice\Model\Resource
     */
    protected function _transformResource(Endpoint $endpoint, array $result)
    {
        $properties = [];

        foreach ($result as $property => $value) {
            if ((substr($property, -4) === '_url') && ($property !== 'html_url')) {
                continue;
            }

            // If this is a relation turn it into a resource as well
            if ((is_array($value)) && (isset($value['id']))) {
                $value = $this->_transformResource($endpoint, $value);
            }

            $properties[$property] = $value;
        }

        if (isset($properties['created_at'])) {
            $properties['created_at'] = new Time($properties['created_at']);
        }

        $resourceClass = $endpoint->resourceClass();
        if (isset($result['type'])) {
            switch ($result['type']) {
                case 'IssuesEvent':
                case 'IssueCommentEvent':
                case 'PullRequestEvent':
                case 'MemberEvent':
                case 'ReleaseEvent':
                case 'WatchEvent':
                    $resourceClass = 'CvoTechnologies\\GitHub\\Model\\Resource\\Event\\' . substr($result['type'], 0, -5) . '\\' . Inflector::classify($result['payload']['action'] . 'Event');
                    break;
                case 'CommitCommentEvent':
                case 'CreateEvent':
                case 'DeleteEvent':
                case 'ForkEvent':
                case 'GollumEvent':
                case 'PullRequestReviewCommentEvent':
                case 'PublicEvent':
                case 'PushEvent':
                    $resourceClass = 'CvoTechnologies\\GitHub\\Model\\Resource\\Event\\' . $result['type'];
                    break;
            }
        }

        return $this->_createResource($resourceClass, $properties);
    }
}
