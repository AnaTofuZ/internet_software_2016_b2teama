<?php
//print_r($posts);

	echo '<div id = board>';
	echo "<center>掲示板</center>";
	echo '</div><br>';

	echo '<div id = link>';
	echo '<center>';
	echo $this->Html->link('新規書き込み',array('action' => 'add'));
	echo " ";
	echo $this->Html->link('TwitterTL',array('action' => '../examples/login'));
	echo '</center>';
	echo '</div><br>';


	foreach($posts as $post){
		echo '<h1>';
		echo $post['Post']['id'].".<br>";
		echo "投稿者:".$post['Users']['name']."<br>";
		echo "twitterID:@".$post['Users']['screen_name']."<br>";
		echo "タイトル:".$post['Post']['title']."<br>";
		echo "本文:".$post['Post']['body']."<br><br>";
		echo $this->Html->link('削除',array('action' => 'delete' ,$post['Post']['id']))."<br>";
		echo $this->Html->link('編集',array('action' => 'edit',$post['Post']['id']))."<br>";
		echo '</h1>';

	}

?>
