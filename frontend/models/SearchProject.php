<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "search_project".
 *
 * @property integer $id
 * @property string $fiters
 * @property integer $users_id
 * @property integer $creationdata
 */
class SearchProject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filters'], 'string'],
            [['creation_date'], 'required'],
            [['users_id', 'creation_date'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filters' => 'Fiters',
            'users_id' => 'Users ID',
            'creation_date' => 'Creationdata',
        ];
    }
}
