<?php

namespace frontend\controllers;

use Yii;
use common\models\BlogPost;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\BlogPostToCategory;
use common\models\BlogTag;
use common\models\BlogCategory;


/**
 * BlogController implements the CRUD actions for BlogPost model.
 */
class BlogController extends Controller
{

    private function cutText($tekst, $max) 
    {
        //sprawdza cz tekst jest dłuższy niż określone maksimum
        if ( mb_strlen($tekst) > $max ) 
        {
            $tekst = mb_substr($tekst, 0, $max);
            $pozycjaSpacji = strrpos($tekst, " ");

            return mb_substr($tekst, 0, $pozycjaSpacji);
        }
        else 
        {
            return $tekst;
        }
    }
    public function actionIndex()
    {
        
        $dataProvider = new ActiveDataProvider([
            'query' => BlogPost::find(),
        ]);
        $oBlogCategory = BlogCategory::find()->all();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'oBlogCategory' => $oBlogCategory,
            'bCategory'=>0
                
        ]);
    }
    public function actionView($sTitleClean)
    {
        $aNewComment = new \common\models\BlogComment();
        //echo '<pre>'. print_r($aComment, TRUE); die();
        $aPost = BlogPost::findOne(['title_clean'=>$sTitleClean]);
        $this->layout = 'blog';
        $model = new \common\models\BlogComment();
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
          $_POST['BlogComment'] = [];
            return $this->render('View', [
                'aPost' => $aPost,
                'aNewComment'=>$aNewComment
            ]);
        }
        else
        {

            $aPost->views = $aPost->views+1;
            $aPost->save(false);
            return $this->render('View', [
                'aPost' => $aPost,
                'aNewComment'=>$aNewComment
            ]);
        }
        
    }
    public function actionKategoria($sTitleClean)
    {   
        $oBlogCategory = BlogCategory::findOne(['nice_name'=>$sTitleClean]);
        $oBlogPostInCategory = BlogPostToCategory::findAll(['category_id'=>$oBlogCategory->id]);
        //echo '<pre>'. print_r($oBlogPostInCategory[0]->category_id, TRUE); die();
        $dataProvider = new ActiveDataProvider([
            'query' => BlogPost::find()->join('LEFT JOIN', 'blog_post_to_category', 'id = post_id')->andFilterWhere(['blog_post_to_category.category_id'=>$oBlogPostInCategory[0]->category_id]),
        ]);
        $oBlogCategoryAll = BlogCategory::find()->all();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'oBlogCategory' => $oBlogCategoryAll,
            'oBlogCategoryOne' => $oBlogCategory,
            'bCategory'=>1
                
        ]);
        return $this->render('index', [
        
        ]);
    }
            
            
   
            

}
