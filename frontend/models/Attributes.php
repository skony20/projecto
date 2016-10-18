<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attributes".
 *
 * @property integer $id
 * @property integer $languages_id
 * @property string $name
 * @property string $description
 *
 * @property Languages $languages
 */
class Attributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languages_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['languages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['languages_id' => 'id']],
            [['sort_order'], 'integer'],
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
            'name' => 'Nazwa',
            'description' => 'Opis - można opuścić',
            'sort_order' => 'Kolejność',
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
