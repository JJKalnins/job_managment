<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class AuthAssignment extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_assignment';
    }

    public function rules()
    {
        return [
            [['item_name','user_id'], 'required'],
        ];
    }
}