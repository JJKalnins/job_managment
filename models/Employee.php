<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Employee extends ActiveRecord
{
    public $sites;
    // public $role;
    public static function tableName()
    {
        return 'EMPLOYEE';
    }

    public function rules()
    {
        return [
            [['name', 'lastname', 'username', 'password', 'birthday', 'access_level'], 'required'], 
            [['birthday'], 'safe'],
        ];
    }
}