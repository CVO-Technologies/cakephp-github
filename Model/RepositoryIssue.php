<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class RepositoryIssue extends GitHubAppModel {

	public $primaryKey = 'number';

	public $displayField = 'title';

	public $useTable = 'issues';

}