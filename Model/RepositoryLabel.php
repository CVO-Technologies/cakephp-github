<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class RepositoryLabel extends GitHubAppModel {

	public $primaryKey = 'name';

	public $displayField = 'name';

	public $useTable = 'labels';

}