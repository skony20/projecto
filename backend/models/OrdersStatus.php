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
 * @property string $background_color
 * @property integer $send_to_client
 *
 * @property Languages $languages
 * @property OrdesStatusHistory[] $ordesStatusHistories
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
            [['languages_id', 'is_default', 'send_to_client'], 'integer'],
            [['name', 'background_color'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['background_color'], 'string', 'max' => 50],
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
            'languages_id' => 'Język',
            'is_default' => 'Domyślny',
            'name' => 'Nazwa',
            'background_color' => 'Kolor tła',
            'send_to_client' => 'Wysyłany do klienta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasOne(Languages::className(), ['id' => 'languages_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdesStatusHistories()
    {
        return $this->hasMany(OrdesStatusHistory::className(), ['orders_status_id' => 'id']);
    }
}
