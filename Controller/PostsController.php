<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 */
class PostsController extends AppController {
//念の為にUserモデルを使用宣言。$scaffoldを使った場合はarray('Post')じゃないとダメ
   public $uses =array('Post');
//利用するコンポーネント(プラグイン)を宣言。
   public $components = array('Auth','Cookie','DebugKit.Toolbar','Security');
   public $helpers = array('Html','Form','Flash');
/**
 * Scaffold
 *
 * @var mixed
 */
//public $scaffold;

//アクション前処理(そこまで書かなくても良い?)
   public function beforefilter(){

      //post処理終了後にindexに遷移
      $this->Post->postRedirect = array('controller' => 'posts','action' => 'index');
      parent::beforeFilter();
   }

    public function index()
    {
        $posts = $this->Post->find('all');
        $this->set('posts',$posts);
    }

    public function add(){
      if($this->request->is('post')){
         $this->Post->create();
         if($this->Post->save($this->request->data('all'))){
             $post = $this->Post->find('all'); //$postにPost->find出来た要素を入れる。これだとおｋ


           /* エラーの原因はここみたい
              $post["id"] = $this->Post["id"];
         $post["title"] = $this->post["title"];
         $post["body"] = $this->post["body"];
         $post["created"] = $this->post["created"];
         $post["modified"] = $this->post["modified"];
            */

         $this->Post->save($post);}
          $this->Session->setFlash(_('Succesed post.'),'default');
         //return $this->redirect(array('action' => 'index'));
      }else{
         $this->Session->setFlash(__('Post don\'t posted .'), 'default', array('class'=>'error-message'), 'auth');
      }

   }


}
