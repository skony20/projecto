<?php

namespace common\models;

use Yii;
use pendalf89\filemanager\behaviors\MediafileBehavior;

/**
 * This is the model class for table "blog_post".
 *
 * @property integer $id
 * @property string $title
 * @property string $article
 * @property string $title_clean
 * @property string $file
 * @property integer $author_id
 * @property string $date_published
 * @property string $banner_image
 * @property integer $featured
 * @property integer $enabled
 * @property integer $comments_enabled
 * @property integer $views
 *
 * @property BlogComment[] $blogComments
 * @property BlogAuthor $author
 * @property BlogPostToCategory[] $blogPostToCategories
 * @property BlogCategory[] $categories
 * @property BlogRelated[] $blogRelateds
 * @property BlogTag[] $blogTags
 */


class BlogPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author_id'], 'required'],
            [['article'], 'string'],
            [['author_id', 'featured', 'enabled', 'comments_enabled', 'views'], 'integer'],
            [['date_published'], 'safe'],
            [['title', 'title_clean', 'banner_image'], 'string', 'max' => 144],
            [['title_clean'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Tytuł',
            'article' => 'Treść',
            'title_clean' => 'Tytuł seo',
            'file' => 'File',
            'author_id' => 'Autor',
            'date_published' => 'Opublikowany',
            'banner_image' => 'Banner',
            'featured' => 'Promowany na stronie głownej ?',
            'enabled' => 'Włączony ?',
            'comments_enabled' => 'Komentarze dozwolone ?',
            'views' => 'Odwiedzin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogComments()
    {
        return $this->hasMany(BlogComment::className(), ['post_id' => 'id'])->andWhere(['is_reply_to_id'=>0]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPostToCategories()
    {
        return $this->hasOne(BlogPostToCategory::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(BlogCategory::className(), ['id' => 'category_id'])->viaTable('blog_post_to_category', ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogRelateds()
    {
        return $this->hasMany(BlogRelated::className(), ['blog_post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTags()
    {
        return $this->hasMany(BlogTag::className(), ['post_id' => 'id']);
    }
  
}
