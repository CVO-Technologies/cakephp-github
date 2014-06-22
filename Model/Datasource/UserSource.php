<?php

App::uses('GitHubSource', 'GitHub.Model/Datasource');

class UserSource extends GitHubSource {

	public function getBaseUrl() {
		return '/users/' . $this->config['username'];
	}
}