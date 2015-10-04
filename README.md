# GitHub plugin

## Installation

### Using Composer

Ensure `require` is present in `composer.json`. This will install the plugin into `Plugin/GitHub`:

```json
{
    "require": {
        "cvo-technologies/github": "3.0.*"
    }
}
```

## Usage

If you want to get information about a specific repository

### Webservice config

Add the following to the ```Webservice``` section of your application config.

```
        'git_hub' => [
            'className' => 'Muffin\Webservice\Connection',
            'service' => 'CvoTechnologies\GitHub\Webservice\Driver\GitHub',
        ]
```

### Controller

```php
<?php

namespace CvoTechnologies\GitHub\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class IssuesController extends Controller
{

    public function beforeFilter(Event $event)
    {
        $this->loadModel('CvoTechnologies/GitHub.Issues', 'Endpoint');
    }

    public function index()
    {
        $issues = $this->Issues->find()->conditions([
            'owner' => 'cakephp',
            'repo' => 'cakephp'
        ]);

        $this->set('issues', $issues);
    }
}
```
