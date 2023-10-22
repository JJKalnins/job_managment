<?php

namespace app\controllers;

use Yii;
use app\models\Workitem;
use app\models\WorkitemSearch;
use app\models\Construction;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class WorkitemController extends Controller
{
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-workitem")) {
            $model = new Workitem();

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-workitem")) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can("view-workitem")) {
            $work_items = Workitem::find()->all();
            $searchModel = new WorkitemSearch();

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'work_items' => $work_items,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-workitem")) {
            $model = $this->findModel($id);
            $model->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }

    protected function findModel($id)
    {
        if (($model = Workitem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
