<?php
namespace frontend\widget;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Reviews;
use yii\data\ActiveDataProvider;
use Yii;
use yii\i18n\Formatter;


class ReviewsWidget extends Widget
{
    public $id;
    public function init()
    {
        parent::init();
        if ($this->id === null) {
                
        }
    }

    public function run()
    {
        $oReviews = new Reviews();
        $oReview = $oReviews->findAll(['products_id'=> $this->id, 'is_active'=>1]);
        foreach ($oReview  as $oReview)
        {
            echo '<div class="review-row">';
                echo '<div class="review-content m14b">';
                    echo $oReview->content;
                echo '</div>';
                echo '<div class="review-footer">';
                    echo '<div class="review-author inline-block">'.$oReview->author. '</div>';
                    echo '<div class="review-date inline-block">'. Yii::$app->formatter->asDate($oReview->creation_date) .'</div>';
                echo '</div>';
            echo '</div>';    
        }
        
    }
    
}
?>