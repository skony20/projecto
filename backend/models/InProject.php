<?php

namespace app\models;

use Yii;
use app\models\Producers;

/**
 * This is the model class for table "in_project".
 *
 * @property integer $id
 * @property integer $producers_id
 * @property string $description
 */
class InProject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['producers_id', 'description'], 'required'],
            [['producers_id'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'producers_id' => 'Pracownia',
            'description' => 'Co w projekcie',
        ];
    }
    
    public function getProducers()
    {
        return $this->hasOne(Producers::className(), ['id' => 'producers_id']);
    }
}
