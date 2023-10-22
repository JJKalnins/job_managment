<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Construction extends ActiveRecord
{   
    public static function tableName()
    {
        return 'CONSTRUCTION_SITE';
    }

    public function rules()
    {
        return [
            [['location', 'sqsize', 'required_access_level'], 'required'],
        ];
    }
}