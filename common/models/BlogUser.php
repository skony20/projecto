<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $website
 *
 * @property BlogComment[] $blogComments
 */
class BlogUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'website'], 'string', 'max' => 45],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nazwa użytkownika',
            'email' => 'adres e-mail',
            'website' => 'strona www',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogComments()
    {
        return $this->hasMany(BlogComment::className(), ['user_id' => 'id']);
    }
}
