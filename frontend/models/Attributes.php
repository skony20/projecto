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
            'id' => Yii::t('app', 'ID'),
            'languages_id' => Yii::t('app', 'Languages ID'),
            'name' => Yii::t('app', 'Nazwa'),
            'description' => Yii::t('app', 'Opis - można opuścić'),
            'sort_order' => Yii::t('app', 'Kolejność'),
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
