<h1>Add Form </h1>
<?php
	echo $this->Form->create('Post',array('url' => array('action' => 'add')));
	echo $this->Form->input('title',array('label' => 'タイトル'));
	echo $this->Form->input('body',array('rows' => '3' ));
	echo $this->Form->end('Save Form');

?>
