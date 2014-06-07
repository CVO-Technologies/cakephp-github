<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class RepositoryPullRequest extends GitHubAppModel {

	public $primaryKey = 'id';

	public $displayField = 'title';

	public $useTable = 'pulls';

}