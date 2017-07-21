<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $nice_name
 * @property integer $enabled
 * @property string $date_created
 *
 * @property BlogPostToCategory[] $blogPostToCategories
 * @property BlogPost[] $posts
 */
class BlogCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['enabled'], 'integer'],
            [['date_created'], 'safe'],
            [['name', 'nice_name'], 'string', 'max' => 45],
            [['nice_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nazwa',
            'nice_name' => 'Nazwa Seo',
            'enabled' => 'Właczona ?',
            'date_created' => 'Data utworzenia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPostToCategories()
    {
        return $this->hasMany(BlogPostToCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(BlogPost::className(), ['id' => 'post_id'])->viaTable('blog_post_to_category', ['category_id' => 'id']);
    }
}
