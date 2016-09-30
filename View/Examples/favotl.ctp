<?php
/**
 * Created by PhpStorm.
 * User: e155730
 * Date: 9/30/16
 * Time: 16:19
*/
	echo '<div id = board>';
	echo "<center>Twitter Time Line</center>";
	echo '</div><br>';

	echo $this->Session->flash(); //メッセージの表示

	echo '<div id = link>';
	echo '<center>';
	echo $this->Html->link('掲示板',array('action' => '../Posts/index'));
	echo " ";
	echo $this->Html->link('ログアウト',array('action' => 'logout'));
	echo '</center>';
	echo '</div>';

//	/	print_r($userData);


	// タイムラインを順番に表示
	foreach($TwitterData as $timeline){
        echo '<h2>';
        // 日付を GMT -> JST 変換し表示形式を整形
        $time = date('m月d日 H:i:s',strtotime($timeline['Favorite']['created_at']));
        /* 簡易表示版
        print $time.'【'.$timeline['user']['name'].'】@'.
            $timeline['user']['screen_name'].' '.$timeline['text'].'<br>';
            */
        // 上の簡易表示をコメントアウトし，以下を有効にすると・・
        print $this->Html->image($timeline['Favorite']['profile_image_url']);
        print $time.'【'.$timeline['Favorite']['name'].'】@'.
            $this->Html->link($timeline['Favorite']['screen_name'],

                'http://www.twitter.com/'.$timeline['Favorite']['screen_name']).'<br>'.
            $timeline['Favorite']['status']."<br>";
        echo " ";
        echo '<br>';
        echo '</h2>';

    }
?>
