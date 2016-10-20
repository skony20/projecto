<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments_method".
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 */
class PaymentsMethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'logo'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'logo' => 'Logo',
        ];
    }
}
