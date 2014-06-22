<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class UserGist extends GitHubAppModel {

	public $useTable = 'gists';

}