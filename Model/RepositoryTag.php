<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class RepositoryTag extends GitHubAppModel {

	public $primaryKey = 'commit.sha';

	public $displayField = 'name';

	public $useTable = 'tags';

}