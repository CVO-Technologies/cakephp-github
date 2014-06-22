<?php

App::uses('GitHubSource', 'GitHub.Model/Datasource');

class OrganizationSource extends GitHubSource {

	public function getBaseUrl() {
		return '/orgs/' . $this->config['name'];
	}
}