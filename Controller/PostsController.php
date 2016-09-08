<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 */
class PostsController extends AppController {
//念の為にUserモデルを使用宣言。$scaffoldを使った場合はarray('Post')じゃないとダメ
   public $uses =array('Post','User');
//利用するコンポーネント(プラグイン)を宣言。 Authはいらないかも
   public $components = array('Auth','Cookie','DebugKit.Toolbar');
/**
 * Scaffold
 *
 * @var mixed
 */
//public $scaffold;

//アクション前処理(そこまで書かなくても良い?)
   /*public function beforefilter(){

      //post処理終了後にindexに遷移
      $this->Post->postRedirect = array('controller' => 'posts','action' => 'index');
      parent::beforeFilter();
   } */

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
         $this->Session->setFlash(_('Succesed post.'),'default');
      }else{
         $this->Session->setFlash(__('Post don\'t posted .'), 'default', array('class'=>'error-message'), 'auth');
      }

   }


}
