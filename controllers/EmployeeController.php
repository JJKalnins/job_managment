<?php

namespace app\controllers;

use Yii;
use app\models\Role;
use app\models\AuthAssignment;
use app\models\Employee;
use app\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\base\Security;

class EmployeeController extends Controller
{
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-employee")) {
            $model = new Employee();
            $roles = $this->getAccessLevelOptions();

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $security = new Security();
                $model->accessToken = $security->generateRandomString(64);
                $model->authKey = $security->generateRandomString(64);

                if ($model->save()) {
                    $auth_model = new AuthAssignment();

                    $auth_model->user_id = $model->id;
                    $auth_model->item_name = $roles[$model->access_level];
                    $auth_model->save();

                    return $this->redirect(['index']);
                }
            }

            return $this->render('create', [
                'model' => $model,
                'access_level_options' => $roles,
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-employee")) {
            $model = $this->findModel($id);
            $auth_model = $this->findAuthModel($id);
            $roles = $this->getAccessLevelOptions();

            $auth_model->save();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $auth_model->user_id = $model->id;
                $auth_model->item_name = $roles[$model->access_level];

                if ($model->save() && $auth_model->save()) {
                    // Data was successfully updated, you can redirect or show a success message
                    return $this->redirect(['index']);
                }
            }
            $roles = $this->getAccessLevelOptions();
            return $this->render('update', [
                'model' => $model,
                'access_level_options' => $roles,
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can("view-employee")) {
            $employees = Employee::find()->all();
            $searchModel = new EmployeeSearch();

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $roles = $this->getAccessLevelOptions();
            
            return $this->render('index', [
                'employees' => $employees,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'access_level_options' => $roles,
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-employee")) {
            $model = $this->findModel($id);
            $model->delete();
            $auth_model = $this->findAuthModel($id);
            $auth_model->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    protected function getAccessLevelOptions()
    {
        $_roles = Role::find()->all();
        $roles = [];

        foreach ($_roles as $role) {
            $roles[$role->id] = $role->name;
        }

        return $roles;
    }

    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAuthModel($id)
    {
        if (($model = AuthAssignment::findOne(["user_id" => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
