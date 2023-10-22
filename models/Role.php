<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Role extends ActiveRecord
{
    public static function tableName()
    {
        return 'ROLE';
    }

    public function rules()
    {
        return [
            // Define any validation rules if needed
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }
}