<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class RepositoryBranch extends GitHubAppModel {

	public $primaryKey = 'commit.sha';

	public $displayField = 'name';

	public $useTable = 'branches';

}