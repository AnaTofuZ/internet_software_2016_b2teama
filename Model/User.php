<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Users';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

<<<<<<< HEAD
    public $primaryKey = 'id_hush';
=======
//primarykeyを変更
    public $primaryKey = 'id_hush';


>>>>>>> master
}
