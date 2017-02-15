<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faq_group".
 *
 * @property integer $id
 * @property integer $is_active
 * @property string $name
 * @property integer $sort_order
 */
class FaqGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active', 'name', 'sort_order'], 'required'],
            [['is_active', 'sort_order'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Włączona',
            'name' => 'Nazwa',
            'sort_order' => 'Kolejność',
        ];
    }
    public function getQuestions()
    {
        return $this->hasMany(Faq::className(), ['faq_group_id' => 'id']);
    }
}
