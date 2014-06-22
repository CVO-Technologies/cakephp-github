<?php

App::uses('GitHubSource', 'GitHub.Lib');

class UserSource extends GitHubSource {

	public function getBaseUrl() {
		return '/users/' . $this->config['username'];
	}
}