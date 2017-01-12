<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newslatter".
 *
 * @property integer $id
 * @property integer $is_verified
 * @property integer $customer_id
 * @property string $email
 * @property integer $register_date
 * @property integer $verified_date
 * @property integer $delete_date
 */
class Newslatter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'newslatter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_verified', 'customer_id', 'register_date', 'verified_date', 'delete_date'], 'integer'],
            [['email'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_verified' => 'Is Verified',
            'customer_id' => 'Customer ID',
            'email' => 'Email',
            'register_date' => 'Register Date',
            'verified_date' => 'Verified Date',
            'delete_date' => 'Delete Date',
        ];
    }
}
