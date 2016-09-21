<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property Users $Users
 */
class Post extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Posts';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */


	public $belongsTo = array(
		'Users' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_hush',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
