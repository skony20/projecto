<?php
    echo $this->render('/layouts/_head');
?>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('/layouts/_navbar'); ?>
</div>
    <?= $this->render('/layouts/_searchbar'); ?>
<div class="wrap question-answer-wrap">
    <div class="container question-answer-container">
        <?= $content ?>
    
    </div>
</div>
<?php
    echo $this->render('/layouts/_iconboxes');
?>
<?php
    echo $this->render('/layouts/_footer');
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
