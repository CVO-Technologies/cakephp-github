<?php

App::uses('AppModel', 'Model');

class GitHubAppModel extends AppModel {

	public function setDataSource($dataSource = null) {
		$db = ConnectionManager::getDataSource($dataSource);
		if (!($db instanceof GitHubSource)) {
			throw new InvalidArgumentException("The specified datasource does not extend GitHubSource");
		}

		parent::setDataSource($dataSource);
	}

}