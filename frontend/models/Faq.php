<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property integer $id
 * @property integer $is_active
 * @property string $question
 * @property string $answer
 * @property integer $sort_order
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active', 'question', 'answer', 'sort_order'], 'required'],
            [['is_active', 'sort_order'], 'integer'],
            [['question', 'answer'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'question' => 'Question',
            'answer' => 'Answer',
            'sort_order' => 'Sort Order',
        ];
    }
}
