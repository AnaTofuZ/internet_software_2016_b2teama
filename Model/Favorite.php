<?php
App::uses('AppModel', 'Model');
/**
 * Favorite Model
 *
 */
class Favorite extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Favorites';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
