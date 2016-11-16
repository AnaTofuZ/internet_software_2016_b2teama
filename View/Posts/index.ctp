<?php
echo <<< EOF
    <div id = board>
	<center>匿名掲示板(匿名とは言ってない)</center>
	</div><br>
      EOF;

	echo $this->Session->flash(); //メッセージの表示

	echo '<center>';
	echo '<a class = "button" href = "/cakephp/Posts/add">';
	echo "新規書き込み";
	echo '</a>';
	echo " ";
	echo '<a class = "button" href = "/cakephp/examples/login">';
	echo "TwitterTL";
	echo '</a>';
	echo '</center><br>';


	foreach($posts as $post){
		echo '<h1>';
		echo $post['Post']['id'].".<br>";
		echo "投稿者:".$post['Users']['name'].$this->Html->image($post['Users']['profile_image_url'])."<br>";
		echo "twitterID:@".$post['Users']['screen_name']."<br>";
		echo "タイトル:".$post['Post']['title']."<br>";
		echo "本文:".$post['Post']['body']."<br><br>";

		echo $this->Html->link('削除',array('action' => 'delete' ,$post['Post']['id']));
		echo " ";
		echo $this->Html->link('編集',array('action' => 'edit',$post['Post']['id']))."<br>";
		echo '</h1>';
	}

?>
