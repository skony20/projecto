<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filters_group".
 *
 * @property integer $id
 * @property integer $is_active
 * @property string $name
 * @property integer $language_id
 * @property string $description
 * @property string $nicename_link
 *
 * @property Languages $language
 */
class FiltersGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filters_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active', 'language_id'], 'integer'],
            [['name', 'language_id'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['sort_order'], 'integer'],
            [['description', 'nicename_link'], 'string', 'max' => 200],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Aktywne',
            'name' => 'Pytanie',
            'language_id' => 'Language ID',
            'description' => 'Opis',
            'nicename_link' => 'Nicename - generowane automatycznie',
            'sort_order' => 'Kolejność sortowania',
        ];
    }
    public static function getFilterGroupName($id)
    {
        $model = FiltersGroup::find()->where(["id" => $id])->one();
        if(!empty($model))
        {
            return $model->name;
        }

        return null;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }
}
