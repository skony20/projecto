<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_status".
 *
 * @property integer $id
 * @property integer $languages_id
 * @property integer $is_default
 * @property string $name
 *
 * @property Languages $languages
 */
class OrdersStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languages_id', 'is_default'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['languages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['languages_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'languages_id' => 'Languages ID',
            'is_default' => 'Is Default',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasOne(Languages::className(), ['id' => 'languages_id']);
    }
}
