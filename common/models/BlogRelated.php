<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_related".
 *
 * @property integer $blog_post_id
 * @property integer $blog_related_post_id
 *
 * @property BlogPost $blogPost
 */
class BlogRelated extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_related';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_post_id', 'blog_related_post_id'], 'required'],
            [['blog_post_id', 'blog_related_post_id'], 'integer'],
            [['blog_post_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPost::className(), 'targetAttribute' => ['blog_post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'blog_post_id' => 'Post główny',
            'blog_related_post_id' => 'Post polecany',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPost()
    {
        return $this->hasOne(BlogPost::className(), ['id' => 'blog_post_id']);
    }
}
