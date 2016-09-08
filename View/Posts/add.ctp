<h1>Add Form </h1>
<?php
	echo $this->Form->create('Form');
	echo $this->Form->input('title');
	echo $this->Form->input('body',array('rows' => '5' ));
	echo $this->Form->end('Save Form');

?>
