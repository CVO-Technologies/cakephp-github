<?php

App::uses('GitHubSource', 'GitHub.Lib');

class RepositorySource extends GitHubSource {

	public function getContent(Model $model, $queryData = array(),
	                           $recursive = null) {
		$json = $this->doRequest('/repos/' . $this->config['owner'] . '/' . $this->config['repository'] . '/' . $model->table);

		$repositoryEntities = array();
		foreach ($json as $index => $entity) {
			$repositoryEntity = array();

			if (is_array($entity)) {
				$repositoryEntity[$model->alias] = $entity;
			} else {
				$fields = array_keys($model->schema());

				$repositoryEntity[$model->alias] = array(
					$fields[0] => $index,
					$fields[1]         => $entity
				);
			}

			$repositoryEntities[] = $repositoryEntity;
		}

		return $repositoryEntities;
	}
}