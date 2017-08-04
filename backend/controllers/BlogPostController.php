<?php

namespace backend\controllers;

use Yii;
use common\models\BlogPost;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\BlogPostToCategory;
use common\models\BlogTag;
use yii\helpers\Json;

/**
 * BlogPostController implements the CRUD actions for BlogPost model.
 */
class BlogPostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'tags'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    private function zamiana($string)
    {
         $polskie = array(',', ' - ',' ','ę', 'Ę', 'ó', 'Ó', 'Ą', 'ą', 'Ś', 'ś', 'ł', 'Ł', 'ż', 'Ż', 'Ź', 'ź', 'ć', 'Ć', 'ń', 'Ń','-',"'","/","?", '"', ":", '!','.', '&', '&amp;', '#', ';', '[',']', '(', ')', '`', '%', '”', '„', '…');
         $miedzyn = array('-','-','-','e', 'e', 'o', 'o', 'a', 'a', 's', 's', 'l', 'ly', 'z', 'z', 'z', 'z', 'c', 'c', 'n', 'n','-',"","","","","",'','', '', '', '', '', '', '', '', '', '', '', '');
         $string = str_replace($polskie, $miedzyn, $string);
         $string = strtolower($string);
         // usuń wszytko co jest niedozwolonym znakiem
         $string = preg_replace('/[^0-9a-z\-]+/', '', $string);
         // zredukuj liczbę myślników do jednego obok siebie
         $string = preg_replace('/[\-]+/', '-', $string);
         // usuwamy możliwe myślniki na początku i końcu
         $string = trim($string, '-');
         $string = stripslashes($string);
         // na wszelki wypadek
         $string = urlencode($string);

         return $string;
    }
    /**
     * Lists all BlogPost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BlogPost::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlogPost model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BlogPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogPost();
        $oBlogPostToCategory = new BlogPostToCategory();
        $oBlogTag = new BlogTag();
        if ($model->load(Yii::$app->request->post())) 
            {
                $model->author_id = Yii::$app->user->identity->id;
                if ($model->save())
                {
                    /*Kategoria*/
                    $oBlogPostToCategory = new BlogPostToCategory();
                    $oBlogPostToCategory->category_id = Yii::$app->request->post('BlogPostToCategory')['category_id'];
                    $oBlogPostToCategory->post_id = $model->id;
                    $oBlogPostToCategory->save();
                    /*Tagi*/
                    $sTags  = Yii::$app->request->post('BlogTag')['tag'];
                    $aTags = explode(',', $sTags);
                    foreach ($aTags as $sTag)
                    {
                        $oBlogTag = new BlogTag();
                        $oBlogTag->tag = $sTag;
                        $oBlogTag->tag_clean = $this->zamiana($sTag);
                        $oBlogTag->post_id = $model->id;
                        $oBlogTag->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            
            } else {
            
            return $this->render('create', [
                'model' => $model,
                'oBlogPostToCategory' =>$oBlogPostToCategory,
                'oBlogTag' => $oBlogTag,
                
            ]);
        }
    }

    /**
     * Updates an existing BlogPost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oPostTag = $model->blogTags;
        
        $aPostTag = [];
        foreach ($oPostTag as $oPostTag)
        {
            $aPostTag[] = $oPostTag->tag;
        }
       // echo '<pre>'. print_r($oPostToCategory, TRUE); die();
        $oBlogTag = $aPostTag;
        if ($model->load(Yii::$app->request->post())) {
             $model->author_id = Yii::$app->user->identity->id;
              if ($model->save())
                {
                    /*Kategoria*/
                    $iCategory = Yii::$app->request->post('BlogPostToCategory')['category_id'];
                    $oBlogPostToCategory = new BlogPostToCategory();
                    $oActualCategory = $oBlogPostToCategory->findOne(['post_id'=>$model->id]);
                    /*Tu aktulane mus być*/
                    $oActualCategory->category_id = $iCategory;
                    $oActualCategory->save();
                    /*Tagi*/
                    $sTags = Yii::$app->request->post('BlogTag')['tag'];
                    $aTags = explode(',', $sTags);
                    $oBlogTag = new BlogTag();
                    $oBlogTag->deleteAll(['post_id'=>$model->id]);
                    foreach ($aTags as $sTag)
                    {
                            $oBlogTag = new BlogTag();

                            $oBlogTag->tag = $sTag;
                            $oBlogTag->tag_clean = $this->zamiana($sTag);
                            $oBlogTag->post_id = $model->id;
                            $oBlogTag->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
        } else {
            $oBlogPostToCategory = BlogPostToCategory::findOne(['post_id'=>$id]);
            return $this->render('update', [
                'model' => $model,
                'oBlogPostToCategory' => $oBlogPostToCategory, 
                'oBlogTag' => $oBlogTag,
            ]);
        }
    }

    /**
     * Deletes an existing BlogPost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BlogPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogPost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionTags()
    {
        $sTerm = $_GET['term'];
        $oBlogTags = new BlogTag();
        $aBlogTags = $oBlogTags->find()->andFilterWhere(['like', 'tag', $sTerm])->one();
        $return = array($aBlogTags->tag);
        return Json::encode($return);
    }
            

}
