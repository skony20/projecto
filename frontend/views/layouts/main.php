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
</div>
    <?= $this->render('/layouts/_searchbar'); ?>
<div class="wrap wrap-breadcrumbs">
    <?= $this->render('/layouts/_breadcramps'); ?>
    </div>
<div class="wrap">    
    <div class="container">     
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
