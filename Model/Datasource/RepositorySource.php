<?php

App::uses('GitHubSource', 'GitHub.Model/Datasource');

class RepositorySource extends GitHubSource {

	public function getBaseUrl() {
		return '/repos/' . $this->config['owner'] . '/' . $this->config['repository'];
	}

}