<?php

App::uses('GitHubSource', 'GitHub.Lib');

class RepositorySource extends GitHubSource {

	public function getBaseUrl() {
		return '/repos/' . $this->config['owner'] . '/' . $this->config['repository'];
	}

}