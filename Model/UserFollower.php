<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class UserFollower extends GitHubAppModel {

	public $displayField = 'login';

	public $useTable = 'followers';

}