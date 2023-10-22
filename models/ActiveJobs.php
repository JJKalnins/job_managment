<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Workitem;
use app\models\Employee;
use app\models\Construction;

class ActiveJobs extends ActiveRecord
{
    public static function tableName()
    {
        return 'ACTIVE_JOBS';
    }

    public function rules()
    {
        return [
            [['employee_id', 'job_id', 'job_location_id'], 'required'],
            [['comment'], 'safe']
        ];
    }

    public function getWorkItem()
    {
        return $this->hasOne(Workitem::class, ['id' => 'job_id']);
    }
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    public function getConstructionSite()
    {
        return $this->hasOne(Construction::class, ['id' => 'job_location_id']);
    }
}
