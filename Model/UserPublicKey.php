<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class UserPublicKey extends GitHubAppModel {

	public $displayField = 'id';

	public $useTable = 'keys';

}