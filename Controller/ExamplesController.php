<?php


// 外部ライブラリとして OAuth(Twitter) をインポート
App::import('Vendor','OAuth/OAuthClient');
class ExamplesController extends AppController {

  public $layout = 'sampleLayout';
  // Examples コントローラで用いる他のモデル(テーブル)
  public $uses = array('User','Post');
  // 利用するコンポーネント(プラグイン)
  public $components = array('Auth','Cookie','DebugKit.Toolbar');
  // コントローラ内の各アクション(関数)を実行する前に処理
  public function beforefilter(){
    // 認証用モデルの指定
    $this->Auth->userModel = 'User';
    // 認証なしでアクセス出来るアクション一覧
    $this->Auth->allow('login','twitter','callback', 'logout');
    // ログイン完了後に移動する標準アクション(v2.2 以前：Auth->redirec()  v2.3以降 Auth->redirectUrl() で利用)
    $this->Auth->loginRedirect = array('controller' => 'examples','action' => 'index');
    // ログアウト後に移動する標準アクション
    $this->Auth->logoutRedirect = array('controller' => 'examples','action' => 'logout');
    // ログイン処理を記述するアクション
    $this->Auth->loginAction = '/examples/login';
    $this->Auth->favoriteRedirect = array('controller' => 'examples','action' => 'index');
    $this->Auth->addRetweetRedirect = array('controller' => 'examples','action' => 'index');


    // 認証で利用するフィールド名
    $this->Auth->fields = array(
        'username' => 'id',
        'password' => 'access_token_key');
    // その他の処理は上位層の beforeFilter を利用
    parent::beforeFilter();
  }
  // login 画面からリンクで呼び出されるアクション(Twitter認証)
  public function twitter(){
    // コンシューマ・キーを用いたインスタンス生成
    $comsumer = $this->__createComsumer();
    // Twitter認証用のリクエスト・トークン生成
    $requestToken = $comsumer->getRequestToken(
      'https://api.twitter.com/oauth/request_token',
      'http://127.0.0.1:8080/cakephp/examples/callback');
    if ($requestToken) {
      // callback で利用するリクエスト・トークンを Session 変数として保存
      $this->Session->write('twitter_request_token', $requestToken);
      // Twitter認証の呼び出し
      $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
    } else {
      $this->Session->setFlash(__('Create Comsumer Failure'), 'default', array('class'=>'error-message'), 'auth');
    }
  }

  // 認証後に呼び出されるアクション
  public function callback() {
    // Session 変数からリクエスト・トークンを取得
    $requestToken=$this->Session->read('twitter_request_token');
    $comsumer = $this->__createComsumer();
    // 認証ユーザのアクセス・トークン取得

    $accessToken = $comsumer->getAccessToken(
          'https://api.twitter.com/oauth/access_token',
          $requestToken);

    if($accessToken){
      // 認証ユーザ情報の取得（戻り値は json 形式）
      $json=$comsumer->get(
        $accessToken->key,
        $accessToken->secret,
        'https://api.twitter.com/1.1/account/verify_credentials.json',
        array());

      // json => 配列変換
      $twitterData = json_decode($json,true);


      $userData="";

      $json=$comsumer->get(
          $accessToken->key,
          $accessToken->secret,
          'https://api.twitter.com/1.1/users/show.json',
          array('user_id' => $twitterData['id'],
              'include_entities' => 'false')
      );

      $userData = json_decode($json,true);



      $key = 'wuo9ieChee1ienai7ur7ahkie1Fee4ei';//暗号化用の鍵用意
      // データベース保存用のデータ生成
      $user['id'] = $twitterData['id_str'];
      $user['id_hush'] = Security::hash($twitterData['id_str'],'sha256',true);
      $user['name'] = $twitterData['name'];
      $user['screen_name'] = $twitterData['screen_name'];
      $user['access_token_key'] = Security::encrypt($accessToken->key,$key);//アクセストークン類を可逆暗号化
      $user['access_token_secret'] = Security::encrypt($accessToken->secret,$key);
      $user['profile_image_url'] = $userData['profile_image_url'];
      // Users テーブルの更新
      $this->User->save($user);
      // Cookie 用に id  を保存
      $key = 'wuo9ieChee1ienai7ur7ahkie1Fee4ei';//暗号化用の鍵用意

      // $cipher = Security::encrypt($user['id'],$key);//暗号化
      $this->Cookie->write('senbei',$user['id_hush']);//暗号化したものをCookieとして渡す->変更:ハッシュ値を送る
      $user['access_token_key'] =  Security::decrypt($user['access_token_key'],$key);
      $user['access_token_secret'] =  Security::decrypt($user['access_token_secret'],$key);
      // Auth Component 内のログイン処理呼び出し
      if ($this->Auth->login($user)) {
        // ログイン完了後のアクションへ遷移
        $this->redirect($this->Auth->redirect());
      }
    }else {
      // アクセス・トークンが取得できない旨をエラー表示
      $this->Session->setFlash(__('AccessToken Getting Failure'), 'default', array('class'=>'error-message'), 'auth');
    }
    $this->redirect('index');
  }


  public function login(){
    // ユーザの認証情報を取得（ログイン済みかどうかを判定）
    $user = $this->Auth->user();
    // Cookie ログインを処理するならこの辺りで・・
    $key = 'wuo9ieChee1ienai7ur7ahkie1Fee4ei';//復号化用キー(暗号化と共通)
	 $cookieValue = $this -> Cookie -> read('senbei'); //Cookieの値を読み込む
    if(isset($cookieValue)){ //Cookieがあったら
    $user = $this ->User->read(null,$cookieValue); //DBの中のレコードをuser定義
      //print_r($user);
        if(empty($user)) {
          //CookieがあってもDB側で値が存在していなかった場合
          $this->Session->setFlash(_('Cookieが不正です。再ログインしてください.'),'default');
        }
        else{

          $user['User']['access_token_key'] = Security::decrypt($user['User']['access_token_key'],$key);
          //print_r($key);
          $user['User']['access_token_secret'] =  Security::decrypt($user['User']['access_token_secret'],$key);


          //  ログイン済みであれば index に遷移
          if(isset($user['id'])){
            return $this->redirect($this->Auth->redirect()); //Twitter認証にぶっ飛ぶ
          }

          if ($this->Auth->login($user[$this->Auth->userModel])) {  //ログイン処理を呼び出して,ログイン出来れば
            /*
             * この時点で$userに保存されている情報は$print_r($user)すれば確認できるが
             * Array ( [User] => Array ( [id] => 1014888828 [name] => 八雲アナグラ [screen_name] => AnaTofuZ
             * [access_token_key] => 1014888828-21sBDgbmfnAi6gHv8CmXaT4ruIvM7u96ZZRL6Sx
             * [access_token_secret] => OB9sO8oO1sY0tYVk9yVtiQmBlikbkkEXRhNU8qRZjNa1n ) )
             * といったUsersテーブルから該当するフィールドを所持している
             */
              return $this->redirect($this->Auth->redirect()); //次の画面に移動
          }
        }
    }

  }

  public function logout(){
    $this->Auth->logout();
    $this->flash('再ログインはこちら','index');
  }
  public function index() {
    $users =$this->Auth->user();
    // Twitter Timeline の表示
    $comsumer = $this->__createComsumer();

    $twitterData="";
    $json=$comsumer->get(
      $users['access_token_key'],
      $users['access_token_secret'],
      'https://api.twitter.com/1.1/statuses/home_timeline.json',
      array('count' => '30')
      );
    $twitterData = json_decode($json,true);


    // Posts テーブル内の全ての情報を読み出す
    //$posts = $this->Post->find('all');
    // View に各変数を引き渡す
    $this->set(compact(
      'users',
      'posts',
      'twitterData'
    ));
    //print_r($data);
  }
  // OAuthClient インスタンス生成 (__ で始まる関数はプライベート関数)
	function __createComsumer(){
		// コンシューマ・キーは  https://apps.twitter.com/ で取得
		return new OAuthClient(
		's8Z785x1q8OAgmhWmmfopA6vB',
		'IGXvOnd6sKW7eAccoliiOiczZAKtzqyI6FKpfexNYJAaR7C9Zy');
	}


	public function favorite($id)
    {


      if (isset($id) && is_numeric($id)) {
       // $user = $this->Auth->user();


        //  $this->render("index");
        $users = $this->Auth->user();

        $comsumer = $this->__createComsumer();


        $comsumer->post(
            $users['access_token_key'],
            $users['access_token_secret'],
            'https://api.twitter.com/1.1/favorites/create.json',
            array('id' => "$id",
                'include_entities' => 'true')
        );


        $this->Session->setFlash('ふぁぼった.');


        return $this->redirect($this->Auth->redirect()); //次の画面に移動


      }

    }

    public function add_retweet($id){


      if (isset($id) && is_numeric($id)) {

        $users = $this->Auth->user();

        $comsumer = $this->__createComsumer();


       $comsumer->post(
            $users['access_token_key'],
            $users['access_token_secret'],
            "https://api.twitter.com/1.1/statuses/retweet/$id.json",
           // array(
            array("id" => $id,
                'trim_user' => false)
        );


        $this->Session->setFlash('りついーとしといた.');
        return $this->redirect($this->Auth->redirect()); //次の画面に移動

      }
    }

    public function tweet(){
      $users = $this->Auth->user();


      if($this->request->is('post')) {
        //この時点で$userの情報を格納しないといけない
        $status = $this->request->data['Example']['status'];

        $comsumer = $this->__createComsumer();


        $comsumer->post(
            $users['access_token_key'],
            $users['access_token_secret'],
            "https://api.twitter.com/1.1/statuses/update.json",
            // array(
            array("status" => $status)
        );


      }

      $this->Session->setFlash('ついーとしといた.');
      return $this->redirect($this->Auth->redirect()); //次の画面に移動


    }

}
?>
