<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-07-26, 12:15:41
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
use yii\helpers\Html;
use yii\helpers\Url;
function cutText($tekst,$ile){
$tekst = strip_tags($tekst);
    if (strlen($tekst) > $ile) 
    {
        $tekst=substr($tekst, 0, $ile);

        for ($a=strlen($tekst)-1;$a>=0;$a--) 
        {
            if ($tekst[$a]==" ") 
            {
                $tekst=substr($tekst, 0, $a)."...";
                break;
            };
        };
   };
return $tekst;
}


$miesiac_pl = array(1 => 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
$this->title = 'Blog - najnowsze wpisy';
$this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['/blog']];
($bCategory ?  $this->params['breadcrumbs'][] =  $oBlogCategoryOne['name'] : '') ;

?>
<div class="site-blog">
    <div class="col-md-12">
        <div class="col-md-6">
            <h1 class="m21b"><?= Html::encode($this->title) ?></h1>
            <div class="green-border"></div>
        </div>
        <div class="col-md-5 blog-category">
            <?php
            echo '<div class="blog-category-link inline-block '.(!$bCategory ? "active_cat" : "" ).'"><a href="'.url::to(yii::getalias("@web").'/blog').'">Wszystkie wpisy</a></div>';
            foreach ($oBlogCategory as $oCategory)
            {

                echo '<div class="blog-category-link inline-block '.((isset($oBlogCategoryOne->id ) ? $oBlogCategoryOne->id == $oCategory['id'] ? "active_cat" : "" :"") ).'"><a href="'.yii::getalias("@web").'/blog/kategoria/'.$oCategory['nice_name'].'.html'.'">'.$oCategory['name'].'</a></div>';
            }
            ?>
            </div>
        </div>
    <?php
    foreach ($dataProvider->models as $oPost)
    {
        $miesiac = date('n', strtotime($oPost->date_published));
    ?>
        <div class="blog-post col-md-12">
            <div class="blog-date inline-block col-md-1">
                <div class="blog-date-container">
                    <span class="blog-date-day"><?=  date('d', strtotime($oPost->date_published));?></span><br>
                    <span class="blog-date-month"><?=$miesiac_pl[$miesiac]?></span>
                </div>
            </div>
            <div class="blog-img inline-block col-md-2">
                <img src ="<?=$oPost->banner_image?>"/>
            </div>
            <div class="blog-article inline-block col-md-6">
                <div class="blog-article-category o12gsm"><i class="fa fa-tags dark-blue" aria-hidden="true"></i> <?=$oPost->blogPostToCategories['category']['name']?></div>

                <?php
                
                ?>
                <div class="blog-article-title"><a href="<?=yii::getalias("@web")?>/blog/<?=$oPost->title_clean?>.html" class=" m18b"><?=$oPost->title?></a></div>
                <div class="blog-article-content"><?=cutText($oPost->article, 150) ?></div>
            </div>
            <div class="blog-comments inline-block col-md-1">
                <i class="fa fa-comments-o fa-2x dark-blue" aria-hidden="true"></i><br>
                (<?=count($oPost->blogComments)?>) komentarzy
            </div>
            <div class="blog-share inline-block col-md-1">
                <i class="fa fa-heart-o fa-2x dark-blue" aria-hidden="true"></i><br>
                (<?=$oPost->share?>) osób poleca
            </div>
            <div class="blog-link inline-block col-md-1">
                
                <a href="<?=yii::getalias("@web")?>/blog/<?=$oPost->title_clean?>.html"><i class="fa fa-external-link fa-2x icon-white" aria-hidden="true"></i></a>
            </div>

        </div>
    <?php
    }
    ?>
</div>
<div class="prjs-pagi">
<?php 
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
    'maxButtonCount'=>4,
]);

?>
</div>