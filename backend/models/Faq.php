<?php

namespace app\models;

use Yii;
use app\models\FaqGroup;

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
            [['is_active', 'question', 'answer', 'sort_order', 'faq_group_id'], 'required'],
            [['is_active', 'sort_order', 'faq_group_id'], 'integer'],
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
            'is_active' => 'Widoczny',
            'question' => 'Pytanie',
            'answer' => 'Odpowiedź',
            'sort_order' => 'Kolejność',
            'faq_group_id' => 'Grupa pytań',
        ];
    }
     public function getGroups()
    {
        return $this->hasOne(FaqGroup::className(), ['id' => 'faq_group_id']);
    }
}
