<?php

namespace CvoTechnologies\GitHub\Webservice;

class IssuesWebservice extends GitHubWebservice
{

    /**
     * Initialize and add nested resources
     */
    public function initialize()
    {
        parent::initialize();

        $this->addNestedResource('/repos/:owner/:repo/issues', [
            'owner',
            'repo'
        ]);
        $this->addNestedResource('/orgs/:org/issues', [
            'org',
        ]);
    }
}
