
<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2016-12-28, 10:09:55
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
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

    <?= $content ?>
<?php
    echo $this->render('/layouts/_footer');
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
