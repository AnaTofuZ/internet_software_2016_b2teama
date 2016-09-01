<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 */
class PostsController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
//public $scaffold;


    public function index()
    {
        $posts = $this->Post->find('all');
        $this->set('posts',$posts);
    }
}
