<?php
	echo '<div id = board>';
	echo "<center>新規書き込み</center>";
	echo '</div><br>';

	echo '<center>';
	echo '<a class = "button" href = "/cakephp/Posts/index">';
	echo "掲示板に戻る";
	echo '</a>';
	echo '</center>';

	echo '<div id = write>';
	echo '<center>';
	echo $this->Form->create('Post',array('url' => array('action' => 'add')));
	echo $this->Form->input('title',array('label' => 'タイトル'));
	echo $this->Form->input('body',array('rows' => '3' ,'label' => '本文'));
	echo $this->Form->end('書き込み');
	echo '</center>';
	echo '</div>';
?>
