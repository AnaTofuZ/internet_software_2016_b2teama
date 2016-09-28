<!DOCTYPE html>
<html lang="ja">
<!-- ここからhead -->
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
    <?php echo $this->Html->meta('icon');?>
    <?php echo $this->Html->css('sample-style.css'); ?>	<!-- webroot/css/base-style.cssを読み込む設定(CSS?何それおいしいの？) -->
    <?php echo $this->fetch('meta');?>
    <?php echo $this->fetch('css');?>
    <?php echo $this->fetch('script');?>
</head>

<!-- ここからbody -->
<body>
<h1>
    <center>掲示板(?)のサンプル</center>
</h1>

<div style="padding: 10px; margin-bottom: 10px; border: 5px double #333333; border-radius: 10px; background-color: #ffff99;">
    <div id="contents">
        <h2><?php echo $this->fetch('content'); ?></h2>
    </div>
</div>



</body>

</html>

//これをPostsController.phpのpublic function index() {}の内部に$this->layout = 'sampleLayout';を記述するとindex.ctp内部で使われる