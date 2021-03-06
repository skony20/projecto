<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_comment".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $is_reply_to_id
 * @property string $comment
 * @property integer $user_id
 * @property integer $mark_read
 * @property integer $enabled
 * @property string $date
 *
 * @property BlogPost $post
 * @property BlogUser $user
 */
class BlogComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'comment', 'name', 'email'], 'required'],
            [['post_id', 'is_reply_to_id', 'mark_read', 'enabled'], 'integer'],
            [['comment', 'name'], 'string'],
            [['email'], 'email'],
            [['date'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPost::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post',
            'is_reply_to_id' => 'Odpowiedź na komentarz ',
            'comment' => 'Komentarz',
            'name' => 'Nazwa uzytkownika',
            'email' => 'e-mail',
            'mark_read' => 'Oznacz jak przeczytane',
            'enabled' => 'Opublikowane ?',
            'date' => 'Data dodania',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(BlogPost::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function Answer($id)
    {
        return BlogComment::findAll(['is_reply_to_id' => $id]);
    }
}
