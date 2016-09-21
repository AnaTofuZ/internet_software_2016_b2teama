# 追記
idのhush値を利用して認証させたかったのでUsersにid__hushというフィールドを追加しています。masterで実装したは確認できてないですが,modelで見るフィールドをid_hushに変えている筈です

パスワードがDBから平文に戻らない問題はvarbinary(255)にすると解決しました
## あっといた方が良い知識

 - git(管理ツール) git-itあたりを使うと良いかも?
 - PHPの知識(多少)?  progateやドットインストールをすると良い

## cakePHPについて
   cakePHPはPHPを用いたフレームワーク。要はwebページを簡単に作れるツール。
   似たようなものにRubyで書かれたRuby on Rails(RoR)がある。


   今回使っているのが2.x系なので [CookBook] (http://book.cakephp.org/2.0/ja/index.html) に説明が乗っているので見てください。ブログチュートリアルはとりあえず読んでください

## 変更するべきディレクトリ等


基本的に操作するディレクトリは
   
 - Model 
 - View
 - Controller 
    
    の3つ。特にControllerを書き換える事が序盤は多い筈。

## ディレクトリ詳細
### Model

   Modelでは使用するDBやController,Viewなどで使う技術を裏で書いておく事が多い。
    例えばDBからフィールドを読む,前や後にhogehogeっていう処理をする場合は,そこに記述を行う。
    
### View
 平たく言えばブラウザで見れるページに関する記述を行う。
 Twitter系ではログインページへのボタンやTLを書いているとこ。データはControllerからもらう。
 
 ここで入力されたデータはセッション変数として保存されるのでController側からでは$this->request->dataなどに保存されている。尚投稿するときのHTTPリクエストはpostなはず
 
### Controller
基本的に **処理** とついたものを行うところ。1モデル1Controller。
Controllerで関数として作られたもの(CakePHPではアクションと呼ぶ)はURLとして入力できるようになる。つまり,view側で指定しないと1アクション1viewが基本となる。

## Controller詳細
よく出てくる **$this->**とは自分のクラスのコンストラクタ。意味がわからないなら今買いてるソースコードの機能を指してると考えて欲しい。

### Auth系

cakePHPにおける認証アクションをまとめたもの。Twitterクライアントではログインやログアウトをするのでここを通すことになる。if文でAuth->loginにデータを送り,ログイン出来ればページを遷移するというControllerを書けばページが送れる。

### DBについて

本来はmySQL等のデータベースと接続をする言語を用いて命令を書かないと行けないけれど,cakePHPはそこを隠蔽して勝手にやってくれる。やったね!
->User->readやsaveがそれ系。詳しくはcookbookを見て欲しい。
変数にDBからフィールド(一列)を持ってくると,配列の中に配列が入っている状態になる。(詳しくはcook(ry ) cookie処理はその辺を考えれば出来るはず。


    DBからreadする際に確認しているフィールドはidフィールド。Modelに記述をすることで変更可能
### デバッグについて

使用するControllerでコンポーネントとしてDebugKit.Toolbarを使用すれば,画面の上にcakeマークがでてきて押すとその時のsession情報などが入る。そこを見て欲しい。また,変数を確認したい場合はprint_r($user);とかすれば確認が出来る。


# 追記(2016/09/21)
### アソシエーションについて

詳しくは [講義ページ](http://www.iis.elec.fuk.kindai.ac.jp/~sira/index.php?%E3%82%A4%E3%83%B3%E3%82%BF%E3%83%BC%E3%83%8D%E3%83%83%E3%83%88%E3%82%BD%E3%83%95%E3%83%88%E3%82%A6%E3%82%A7%E3%82%A2%2F2016%E5%B9%B4%E5%BA%A6%2FCakePHP#jb4fda69) 参照。ForeingKeysは僕の設定だとuser_id_hush 。要はPosts側の設定となる。
この昨日はForeingKeysを動的に取ってくるわけではないので,何かしらの記述が必要。
考えられるのは `$user = $this->Auth->user();`すると `$user`に AUthでログインしたユーザ情報が入る。
それを使うとうまくいきそう。
データ保存系は[ここを参照](http://book.cakephp.org/2.0/ja/models/saving-your-data.html) (データバリデーションも) 
