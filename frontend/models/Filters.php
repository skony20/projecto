<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "filters".
 *
 * @property integer $id
 * @property string $name
 * @property integer $language_id
 * @property integer $is_active
 * @property string $description
 * @property integer $filters_group_id
 * @property string $nicename_link
 */
class Filters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['language_id', 'is_active', 'filters_group_id', 'sort_order'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description', 'nicename_link'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>'ID',
            'name' =>'Odpowiedź',
            //'language_id' =>'Język',
            'is_active' =>'Aktywny',
            'description' =>'Opis',
            'sort_order' =>'Kolejność',
            'filters_group_id' =>'Pytanie',
            'nicename_link' =>'Nicename - generowane automatycznie',
        ];
    }

    /**
     * @inheritdoc
     * @return FiltersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FiltersQuery(get_called_class());
    }
}
