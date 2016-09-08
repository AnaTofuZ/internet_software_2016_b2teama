<?php

print_r($posts);

	foreach($posts as $post){
		echo $post['Post']['title']."<br>";
		echo $post['Post']['body']."<br>";
}

?>
