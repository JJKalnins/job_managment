<?php

namespace app\controllers;

use Yii;
use app\models\ActiveJobs;
use app\models\Construction;
use app\models\Employee;
use app\models\Workitem;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class ActiveJobsController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->can("manage-activejobs")) {
            $employees = Employee::find()->all();
            $work_items = Workitem::find()->select(["name", 'id'])->asArray()->all();

            $active_jobs = ActiveJobs::find()->all();
            $construction_sites = Construction::find()->all();

            $job_data = [];

            foreach ($active_jobs as $active_job) {
                if (!isset($job_data[$active_job->employee_id])) {
                    $job_data[$active_job->employee_id] = [];
                }

                $job_data[$active_job->employee_id][$active_job->job_location_id][$active_job->job_id] = $active_job->job_id;
            }

            $construction_site_names = []; // Rename this better
            foreach ($construction_sites as $construction_site) {
                $construction_site_names[$construction_site->id] = $construction_site->location;
            }

            foreach ($employees as $key => $employee) {
                $__construction_sites = Construction::find()
                    ->where(['<=', 'required_access_level', $employee->access_level])
                    ->all();

                $sites = [];
                foreach ($__construction_sites as $__construction_site) {
                    if (empty($job_data) || !isset($job_data[$employee->id]) || !array_key_exists($__construction_site->id, $job_data[$employee->id])) {
                        $sites[$__construction_site->id . "_"] = $__construction_site->location;
                    }
                }
                $employees[$key]->sites = $sites;
            }

            return $this->render('index', [
                'employees' => $employees,
                'work_items' => $work_items,
                'job_data' => $job_data,
                'construction_site_names' => $construction_site_names,
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionUpdate()
    {
        if (Yii::$app->user->can("update-activejobs")) {
            $assigned_jobs = Yii::$app->request->post()['assigned_jobs'];

            $new_saved_ids = [];
            foreach ($assigned_jobs as $assigned_job) {
                $model = new ActiveJobs();
                $model->employee_id = $assigned_job['person_id'];
                $model->job_id = $assigned_job['work_id'];
                $model->job_location_id = $assigned_job['location_id'];

                if ($model->validate() && $model->save()) {
                    $new_saved_ids[] = $model->id;
                }
            }
            $active_jobs = ActiveJobs::find()->all();

            foreach ($active_jobs as $active_job) {
                if (!in_array($active_job->id, $new_saved_ids)) {
                    $model = $this->findModel($active_job->id);
                    $model->delete();
                }
            }
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionList()
    {
        if (Yii::$app->user->can("list-activejobs")) {
            $active_jobs = ActiveJobs::find()
                ->with('workItem')
                ->with('constructionSite')
                ->where(["employee_id" => Yii::$app->user->identity->id])
                ->all();

            return $this->render('list', [
                "active_jobs" => $active_jobs
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    protected function findModel($id)
    {
        if (($model = ActiveJobs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
