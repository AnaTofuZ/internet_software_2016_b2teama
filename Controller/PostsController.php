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
   public function beforeFilter(){

       //認証用ModelはTwitter認証を踏まえてTwitterDBに設定
       $this->Auth->userModel = 'User';

       $this->Auth->allow('login','callback','logout');

      //post処理終了後にindexに遷移
      $this->Post->postRedirect = array('controller' => 'posts','action' => 'index');

       //ログイン処理語に移動する標準アクション

       $this->Auth->loginRedirect = array('controller' => 'posts','action' => 'index');
        //ログイン処理を記述するアクション(Twitterexampleと共通)
       $this->Auth->loginAction = '/examples/login';

       $this->Security->validatePost = true; // 改竄対策を無効
       $this->Security->csrfCheck = false;    // CSR対策を無効

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
        $user = $this->Auth->user();
        /*
         * 既にAuthでログイン済みなのでこの時点で$userには
         * Array ( [id] => 1014888828 [id_hush] => 略
         * [name] => 八雲アナグラ [screen_name] => AnaTofuZ
         *  [access_token_key] => 1014888828-21sBDgbmfnAi6gHv8CmXaT4ruIvM7u96ZZRL6Sx
         * [access_token_secret] => OB9sO8oO1sY0tYVk9yVtiQmBlikbkkEXRhNU8qRZjNa1n )
         * が入っている
         */
        //print_r($user);

        if($this->request->is('post')){
         $this->Post->create();
         if($this->Post->save($this->request->data)){
             //$post = $this->Post->find('all'); //$postにPost->find出来た要素を入れる。これだとおｋ


         //    エラーの原因はここみたい
              $post["Post"]["id"] = $this->Post["Post"]["id"];
         $post["Post"]["title"] = $this->post["Post"]["title"];
         $post["Post"]["body"] = $this->post["Post"]["body"];
         $post["Post"]["created"] = $this->post["Post"]["created"];
         $post["Post"]["modified"] = $this->post["Post"]["modified"];

         $post["Post"]["user_id_hush "] = $user->id_hush;
         $this->Post->save($post);}
          $this->Session->setFlash(_('Succesed post.'),'default');
         return $this->redirect(array('action' => 'index'));
      }else{
         $this->Session->setFlash(__('Post don\'t posted .'), 'default', array('class'=>'error-message'), 'auth');
      }

   }


}
