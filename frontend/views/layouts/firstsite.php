<?php
    echo $this->render('/layouts/_head');
?>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('/layouts/_navbar'); ?>
    <div class="container">
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
