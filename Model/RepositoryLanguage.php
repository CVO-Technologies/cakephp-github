<?php

App::uses('GitHubAppModel', 'GitHub.Model');

class RepositoryLanguage extends GitHubAppModel {

	public $primaryKey = 'name';

	public $displayField = 'name';

	public $useTable = 'languages';

	public $schema = array(
		'name'      => array(
			'type'   => 'text',
			'null'   => false,
			'key'    => 'primary'
		),
		'bytes'    => array(
			'type'   => 'integer',
			'null'   => false,
			'length' => 11,
		)
	);


}