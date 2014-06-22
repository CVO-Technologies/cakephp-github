<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class UserOrganization extends GitHubAppModel {

	public $primaryKey = 'login';

	public $displayField = 'login';

	public $useTable = 'orgs';

}