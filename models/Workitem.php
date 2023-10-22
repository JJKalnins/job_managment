<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class WorkItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'WORK_ITEM';
    }

    public function rules()
    {
        return [
            [['name', 'default_comment'], 'required'], 
        ];
    }
}