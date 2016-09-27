<?php
	// タイムラインを順番に表示
	foreach($twitterData as $timeline){
		echo '<h2>';
		// 日付を GMT -> JST 変換し表示形式を整形
		$time = date('m月d日 H:i:s',strtotime($timeline['created_at']));
		/* 簡易表示版
		print $time.'【'.$timeline['user']['name'].'】@'.
			$timeline['user']['screen_name'].' '.$timeline['text'].'<br>';
			*/
		// 上の簡易表示をコメントアウトし，以下を有効にすると・・
		print $this->Html->image($timeline['user']['profile_image_url']);
		print $time.'【'.$timeline['user']['name'].'】@'.
			$this->Html->link($timeline['user']['screen_name'],
			'http://www.twitter.com/'.$timeline['user']['screen_name']).
			$timeline['text'].'<br>';
			echo '</h2>';
	}
	/*
	echo '<tr>';
	echo '<table><tr><th>id</th><th>タイトル</th><th>内容</th><th>作成日</th><th>変更日</th></tr>';
    foreach($posts as $post){
      echo '<tr>';
      echo '<td>'.$post['Post']['id'].'</td>';
      echo '<td>'.$post['Post']['title'].'</td>';
      echo '<td>'.$post['Post']['body'].'</td>';
      echo '<td>'.$post['Post']['created'].'</td>';
      echo '<td>'.$post['Post']['modified'].'</td>';
      echo '</tr></tr>';
    */

			  echo '<tr>';
        echo $this->Html->link('掲示板',array('action' => '../Posts/index'));
        echo '</tr><br>';
    //}
        echo '</table>';
        echo $this->Html->link('ログアウト',array('action' => 'logout'));
?>
