<?php
	echo '<div id = board>';
	echo "<center>Twitter Time Line</center>";
	echo '</div><br>';

	echo $this->Session->flash(); //メッセージの表示

	echo '<center>';
	echo '<a class = "button" href = "/cakephp/Posts/index">';
	echo "掲示板";
	echo '</a>';
	echo " ";
	echo '<a class = "button" href = "/cakephp/examples/logout">';
	echo "ログアウト";
	echo '</a>';
	echo '</center>';

	echo '<div id = write>';
	echo '<center>';
	print "こいつログイン中→";
	print $this->Html->image($users['profile_image_url']);
	print '【'.$users['name'].'】@'.
	$this->Html->link($users['screen_name'],
		'http://www.twitter.com/'.$users['screen_name']);

	echo $this->Form->create('Example',array('url' => array('action' => 'tweet')));
	echo $this->Form->input('status',array('rows' => '3' ,'label' => '本文'));
	echo $this->Form->end('ツイート');
	echo '</center>';
	echo '</div>';

	// タイムラインを順番に表示
	foreach($twitterData as $timeline){
		echo '<h2>';
		// 日付を GMT -> JST 変換し表示形式を整形
		$time = date('m月d日 H:i:s',strtotime($timeline['created_at']));
		print $this->Html->image($timeline['user']['profile_image_url']);
		print $time.'【'.$timeline['user']['name'].'】@'.
			$this->Html->link($timeline['user']['screen_name'],
			'http://www.twitter.com/'.$timeline['user']['screen_name']).'<br>'.
			$timeline['text']."<br>";
		echo $this->Html->link('ふぁぼ',array('action' => 'favorite' ,$timeline['id']));
		echo " ";
		echo $this->Html->link('りついーと',array('action' => 'add_retweet' ,$timeline['id']));
		echo '<br>';
		echo '</h2>';
	}
?>
