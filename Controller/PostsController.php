<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 */
class PostsController extends AppController {
//念の為にUserモデルを使用宣言。$scaffoldを使った場合はarray('Post')じゃないとダメ
   public $uses =array('Post','User');
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

       //認証用ModelはTwitter認証を踏まえてTwitterDBに設定
       $this->Auth->userModel = 'User';

       $this->Auth->allow('login','callback','logout');

      //post処理終了後にindexに遷移
      $this->Post->postRedirect = array('controller' => 'posts','action' => 'index');

        //ログイン処理を記述するアクション(Twitterexampleと共通)
       $this->Auth->loginAction = '/examples/login';
      parent::beforeFilter();
   }

   public function login(){

   }

    public function index()
    {
        $posts = $this->Post->find('all');
        $this->set('posts',$posts);
    }

    public function add(){
      if($this->request->is('post')){
         $this->Post->create();
         if($this->Post->save($this->request->data)){
             $post = $this->Post->find('all'); //$postにPost->find出来た要素を入れる。これだとおｋ


         /*    エラーの原因はここみたい
              $post["Post"]["id"] = $this->Post["Post"]["id"];
         $post["Post"]["title"] = $this->post["Post"]["title"];
         $post["Post"]["body"] = $this->post["Post"]["body"];
         $post["Post"]["created"] = $this->post["Post"]["created"];
         $post["Post"]["modified"] = $this->post["Post"]["modified"];
       */
         $this->Post->save($post);}
          $this->Session->setFlash(_('Succesed post.'),'default');
         //return $this->redirect(array('action' => 'index'));
      }else{
         $this->Session->setFlash(__('Post don\'t posted .'), 'default', array('class'=>'error-message'), 'auth');
      }

   }


}
