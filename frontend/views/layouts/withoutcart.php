<?php
    echo $this->render('/layouts/_head');
?>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('/layouts/_navbar'); ?>
    <div class="container">
        <?= $this->render('/layouts/_breadcamps'); ?>
        <?= $content ?>
    
    </div>
</div>
<?php
    echo $this->render('/layouts/_footer');
?>
<?php $this->endBody() ?>
<?php
    echo $this->render('/layouts/_extra_footer');
?>
</body>
</html>
<?php $this->endPage() ?>
