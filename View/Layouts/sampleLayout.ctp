<!DOCTYPE html>
<html lang="ja">
<head>
    <?php echo $this->Html->charset(); ?>
    <meta name="copyright" content="&copy; atomicbox">
    <title><?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon');?>
    <?php echo $this->fetch('meta');?>
    <?php echo $this->Html->css('base-style.css'); ?>
    <?php echo $this->fetch('css');?>
    <?php echo $this->fetch('script');?>
</head>

<body>
<div id="contents">
    <h1>ウェイソイヤ</h1>
    <?php echo $this->fetch('content'); ?>
</div>
<p id="copyright">&copy; asdfasdf</p>
</div>
</body>

</html>

//これをPostsController.phpのpublic function index() {}の内部に$this->layout = 'sampleLayout';を記述するとindex.ctp内部で使われる