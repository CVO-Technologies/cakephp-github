<?php

App::uses('DataSource', 'Model/Datasource');
App::uses('HttpSocket', 'Network/Http');

abstract class GitHubSource extends DataSource {

	/**
	 * listSources() is for caching. You'll likely want to implement caching in
	 * your own way with a custom datasource. So just ``return null``.
	 */
	public function listSources($data = null) {
		return null;
	}

	public function describe($model) {
		return $model->schema;
	}

	/**
	 * calculate() is for determining how we will count the records and is
	 * required to get ``update()`` and ``delete()`` to work.
	 *
	 * We don't count the records here but return a string to be passed to
	 * ``read()`` which will do the actual counting. The easiest way is to just
	 * return the string 'COUNT' and check for it in ``read()`` where
	 * ``$data['fields'] === 'COUNT'``.
	 */
	public function calculate(Model $model, $func, $params = array()) {
		return 'COUNT';
	}

	/**
	 * Implement the R in CRUD. Calls to ``Model::find()`` arrive here.
	 */
	public function read(Model $model, $queryData = array(),
	                     $recursive = null) {
		$data = $this->getContent($model, $queryData, $recursive);

		if (is_array($queryData['fields'])) {
			foreach ($data as &$entry) {
				$newData = array();

				foreach ($queryData['fields'] as $field) {
					$fieldData = Hash::extract($entry, $field);

					$newData = Hash::insert($newData, $field, $fieldData[0]);
				}

				$entry = $newData;
			}
		}

		foreach ($queryData['order'] as $path => $direction) {
			if (is_array($direction)) {
				foreach ($direction as $subPath => $subDirection) {
					$data = Hash::sort($data, $subPath, $subDirection);
				}
			} else {
				$data = Hash::sort($data, $path, $direction);
			}
		}

		if ($queryData['limit']) {
			$offset = ($queryData['offset']) ? $queryData['offset'] : 0;

			$data = array_slice($data, $offset, $queryData['limit']);
		}

		if ($queryData['fields'] === 'COUNT') {
			return array(array(array('count' => count($data))));
		}

		return $data;
	}

	public function doRequest($uri, array $parameters = array()) {
		if (isset($this->config['client_id'])) {
			$parameters['client_id'] = $this->config['client_id'];
		}
		if (isset($this->config['client_secret'])) {
			$parameters['client_secret'] = $this->config['client_secret'];
		}

		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, 'https://api.github.com' . $uri . '?' . http_build_query($parameters));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'CakePHP GitHub plugin');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = json_decode(curl_exec($ch), true);

		if (isset($response['message'])) {
			throw new CakeException(__('GitHub datasource error: %1$s', $response['message']));
		}

		return $response;
	}

	public function getContent(Model $model, $queryData = array(),
	                           $recursive = null) {
		$url = $this->getBaseUrl() . '/' . $model->table;

		$queryParameters = array();
		if (count($queryData['conditions'])) {
			foreach ($queryData['conditions'] as $field => $data) {
				$fieldParts = explode('.', $field);

				if (is_array($data)) {
					$data = implode(',', $data);
				}

				$queryParameters[end($fieldParts)] = $data;
			}
		}
		if (count($queryData['order'][0])) {
			foreach ($queryData['order'][0] as $field => $direction) {
				$fieldParts = explode('.', $field);

				$queryParameters['sort'] = end($fieldParts);
				$queryParameters['direction'] = strtolower($direction);
			}
		}

		$json = $this->doRequest($url, $queryParameters);

		$entities = array();
		foreach ($json as $index => $entity) {
			$dataEntity = array();

			if (is_array($entity)) {
				$dataEntity[$model->alias] = $entity;
			} else {
				$fields = array_keys($model->schema());

				$dataEntity[$model->alias] = array(
					$fields[0] => $index,
					$fields[1]         => $entity
				);
			}

			$entities[] = $dataEntity;
		}

		return $entities;
	}

	abstract public function getBaseUrl();

}