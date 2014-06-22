<?php

App::uses('GitHubSource', 'GitHub.Lib');

class OrganizationSource extends GitHubSource {

	public function getBaseUrl() {
		return '/orgs/' . $this->config['name'];
	}
}