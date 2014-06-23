# GitHub plugin

## Installation

* Clone/Copy the files in this directory into `app/Plugin/GitHub`

This can be done with the git submodule command
```sh
git submodule add https://github.com/mms-projects/cakephp-github-plugin.git app/Plugin/DebugKit
```

* Ensure the plugin is loaded in `app/Config/bootstrap.php` by calling `CakePlugin::load('GitHub');`

### Using Composer

Ensure `require` is present in `composer.json`. This will install the plugin into `Plugin/GitHub`:

```json
{
    "require": {
        "cvo-technologies/github": "*"
    }
}
```

## Usage

If you want to get information about a specific repository

### Database config

```php
<?php

class DATABASE_CONFIG {
    public $cakephpRepository = array(
        'datasource' => 'GitHub.RepositorySource',
        'owner'      => 'cakephp',
        'repository' => 'cakephp'
    );
}
```

### Controller

```php
<?php

App::uses('AppController', 'Controller');

class IssuesController extends AppController {

    public $uses = array('GitHub.Issue');

    public function index() {
        $this->Issue->setDataSource('cakephpRepository');
       
        $issues = $this->Issue->find('all', array(
            'conditions' => array(
                'Issue.state' => 'open'
            )
        ));
        
        $this->set(compact('issues'));
    }

}
```
