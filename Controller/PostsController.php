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

    public function add(){
      if($this->request->is('post')){
         $this->Post->create();
         if($this->Post->save($this->request->data)){
         $posts["Post"]["id"] = $this->post["Post"]["id"];
         $posts["Post"]["title"] = $this->post["Post"]["title"];
         $post["Post"]["body"] = $this->post["Post"]["body"];
         $post["Post"]["created"] = $this->post["Post"]["created"];
         $post["Post"]["modified"] = $this->post["Post"]["modified"];
         $this->Post->save($post);}
      }else{
         $this->Session->setFlash(__('Post don\'t posted .'), 'default', array('class'=>'error-message'), 'auth');
      }

   }

}
