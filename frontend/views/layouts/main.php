<?php
    echo $this->render('/layouts/_head');
?>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    echo $this->render('/layouts/_navbar');
    echo $this->render('/layouts/_cart');
    ?>
    <div class="container">
        <?= $this->render('/layouts/_breadcamps'); ?>
         <?= $content ?>

    </div>
</div>
<?php
    echo $this->render('/layouts/_footer');
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
