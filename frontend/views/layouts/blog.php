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
<div class="wrap blog-wrap">    
    <div class="container blog-container">     
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