<?php

namespace CvoTechnologies\GitHub\Webservice;

use Cake\Network\Http\Response;
use Cake\Utility\Hash;
use Muffin\Webservice\Model\Endpoint;
use Muffin\Webservice\Query;
use Muffin\Webservice\ResultSet;
use Muffin\Webservice\Webservice\Webservice;

/**
 * Class GitHubWebservice
 *
 * @package CvoTechnologies\GitHub\Webservice
 */
class GitHubWebservice extends Webservice
{

    /**
     * Returns the base URL for this endpoint
     *
     * @return string Base URL
     */
    public function getBaseUrl()
    {
        return '/' . $this->endpoint();
    }

    /**
     * {@inheritDoc}
     */
    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $url = $this->getBaseUrl();

        $queryParameters = [];
        // Page number has been set, add to query parameters
        if ($query->page()) {
            $queryParameters['page'] = $query->page();
        }
        // Result limit has been set, add to query parameters
        if ($query->limit()) {
            $queryParameters['per_page'] = $query->limit();
        }

        $search = false;
        $searchParameters = [];
        if ($query->clause('where')) {
            foreach ($query->clause('where') as $field => $value) {
                switch ($field) {
                    case 'id':
                    default:
                        // Add the condition as search parameter
                        $searchParameters[$field] = $value;

                        // Mark this query as a search
                        $search = true;
                }
            }
        }

        // Check if this query could be requested using a nested resource.
        if ($nestedResource = $this->nestedResource($query->clause('where'))) {
            $url = $nestedResource;

            // If this is the case turn search of
            $search = false;
        }

        if ($search) {
            $url = '/search' . $url;

            $q = [];
            foreach ($searchParameters as $parameter => $value) {
                $q[] = $parameter . ':' . $value;
            }

            $queryParameters['q'] = implode(' ', $q);
        }

        /* @var Response $response */
        $response = $this->driver()->client()->get($url, $queryParameters);
        if (!$response->isOk()) {
            return false;
        }

        /* @var int $resourceAmount Total amount of resources */
        $resourceAmount = false;

        // Parse the Link header containing pagination info
        $links = $this->_parseLinks($response->header('Link'));
        if (isset($links['last'])) {
            $linkParameters = $this->_linkQueryParameters($links['last']);

            // Grab the last page number out of the Link header
            if ((isset($linkParameters['page'])) && (isset($linkParameters['per_page']))) {
                $resourceAmount = $linkParameters['page'] * $linkParameters['per_page'];
            }
        }

        $results = false;
        if ($search) {
            $results = $response->json['items'];

            $resourceAmount = $response->json['total_count'];
        }
        if ($results === false) {
            $results = $response->json;
        }

        // Turn results into resources
        $resources = $this->_transformResults($query->endpoint(), $results);

        return new ResultSet($resources, $resourceAmount);
    }

    /**
     * {@inheritDoc}
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

        return $this->_createResource($endpoint->resourceClass(), $properties);
    }

    /**
     * Parse Link headers from response.
     *
     * @param array $links List of Link headers
     * @return array
     */
    protected function _parseLinks(array $links)
    {
        $links = array_map(function ($value) {
            $matches = [];
            preg_match('/\<(?P<link>.*)\>\; rel\=\"(?P<rel>.*)\"/', $value, $matches);

            return $matches;
        }, explode(', ', $links));

        return Hash::combine($links, '{n}.rel', '{n}.link');
    }

    /**
     * Returns the query parameters from a link in the Link header
     *
     * @param string $link The link to extract
     * @return array List of parameters
     */
    protected function _linkQueryParameters($link)
    {
        $parameters = [];
        parse_str(parse_url($link, PHP_URL_QUERY), $parameters);

        return $parameters;
    }
}
