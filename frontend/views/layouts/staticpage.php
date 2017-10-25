
<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2016-12-23, 09:00:53
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
