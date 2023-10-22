<?php

namespace app\controllers;

use app\models\ActiveJobs;
use yii\rest\ActiveController;
use yii\data\ArrayDataProvider;

class PassController extends ActiveController
{
    public $modelClass = 'app\models\ActiveJobs';

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        try {
            $queryParams = \Yii::$app->request->queryParams;

            $query = ActiveJobs::find();

            if (isset($queryParams['job_site_id'])) {
                // Apply a filter condition
                $query->andWhere(['job_location_id' => $queryParams['job_site_id']]);
            } else {
                throw new \Exception('Parameter "job_site_id" expected in request');
            }

            if (isset($queryParams['sort'])) {
                // Apply sorting
                $query->orderBy($queryParams['sort']);
            }

            $query->joinWith('employee');
            $query->select(['employee_id', 'employee.name']);

            $employee_data = [];

            $results = $query->all();

            foreach($results as $result){
                $employee_data[$result->employee_id] = [
                    'name' => $result->employee->name,
                    'lastname' => $result->employee->lastname
                ];
            }

            $dataProvider = new ArrayDataProvider([
                'allModels' => $employee_data,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            return $dataProvider;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
