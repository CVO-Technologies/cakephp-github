<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class RepositoryContributor extends GitHubAppModel {

	public $displayField = 'login';

	public $useTable = 'contributors';

}