# GitHub plugin

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Build Status](https://img.shields.io/travis/CVO-Technologies/cakephp-github/master.svg?style=flat-square)](https://travis-ci.org/CVO-Technologies/cakephp-github)
[![Coverage Status](https://img.shields.io/codecov/c/github/cvo-technologies/cakephp-github.svg?style=flat-square)](https://codecov.io/github/cvo-technologies/cakephp-github)
[![Total Downloads](https://img.shields.io/packagist/dt/cvo-technologies/cakephp-github.svg?style=flat-square)](https://packagist.org/packages/cvo-technologies/cakephp-github)
[![Latest Stable Version](https://img.shields.io/packagist/v/cvo-technologies/cakephp-github.svg?style=flat-square&label=stable)](https://packagist.org/packages/cvo-technologies/cakephp-github)

## Installation

### Using Composer

Ensure `require` is present in `composer.json`. This will install the plugin into `Plugin/GitHub`:

```json
{
    "require": {
        "cvo-technologies/cakephp-github": "~1.1"
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
            'service' => 'CvoTechnologies/GitHub.GitHub',
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
        $issues = $this->Issues->find()->where([
            'owner' => 'cakephp',
            'repo' => 'cakephp'
        ]);

        $this->set('issues', $issues);
    }
}
```
