<?php
/**
 * Created by PhpStorm.
 * User: e155730
 * Date: 9/30/16
 * Time: 11:46
 */
echo '<div id = board>';
echo "<center>へんさう</center>";
echo '</div>';
echo '<div id = write>';
echo '<center>';
echo $this->Form->create('Post',array('url' => array('action' => 'edit')));
echo $this->Form->input('title',array('label' => 'タイトル'));
echo $this->Form->input('body',array('rows' => '3' ,'label' => '本文'));
echo $this->Form->end('更新');
echo '</center>';
echo '</div><br>';
echo $this->Html->link('掲示板に戻る',array('action' => 'index'));
?>
