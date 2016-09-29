<!DOCTYPE html>
<html lang="ja">
<!-- ここからhead -->
<head>

	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
		<?php echo $this->Html->meta('icon');?>
		<?php echo $this->Html->css('sampleStyle.css'.'?'.time()); ?>	<!-- .'?'.time()を追加するとキャッシュがなくなって再起動しなくてもいいらしいがうまくいかない -->
		<?php echo $this->fetch('meta');?>
		<?php echo $this->fetch('css');?>
		<?php echo $this->fetch('script');?>
</head>

<!-- ここからbody -->
<body>

	<div id = content>
		<?php echo $this->fetch('content'); ?>
	</div>
</body>

</html>
