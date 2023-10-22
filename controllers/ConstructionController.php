<?php

namespace app\controllers;

use Yii;
use app\models\Construction;
use app\models\ConstructionSearch;
use app\models\Role;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class ConstructionController extends Controller
{
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-construction")) {
            $model = new Construction();

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                // Data was successfully inserted, you can redirect or show a success message
                if ($model->save()) {
                    return $this->redirect(['index');
                }
            }

            $roles = $this->getAccessLevelOptions(); 

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
        if (Yii::$app->user->can("update-construction")) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                if ($model->save()) {
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
        if (Yii::$app->user->can("view-construction")) {
            $construction_sites = Construction::find()->all();
            $searchModel = new ConstructionSearch();

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $roles = $this->getAccessLevelOptions();

            return $this->render('index', [
                'construction_sites' => $construction_sites,
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
        if (Yii::$app->user->can("delete-construction")) {
            $model = $this->findModel($id);
            $model->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('You do not have permission to perform this action.');
        }
    }    
    protected function getAccessLevelOptions(){
        $_roles = Role::find()->all();
        $roles = [];

        foreach($_roles as $role){
            $roles[$role->id] = $role->name;
        }
        
        return $roles;
    }

    protected function findModel($id)
    {
        if (($model = Construction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
