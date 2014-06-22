<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class Issue extends GitHubAppModel {

	public $primaryKey = 'number';

	public $displayField = 'title';

	public $useTable = 'issues';

}