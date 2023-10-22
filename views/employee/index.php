<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee List';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="employee-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Create New Employee', ['employee/create'], ['class' => 'btn btn-primary']) ?>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'lastname',
            'username',
            'birthday',
            [
                'attribute' => 'access_level',
                'filter' => $access_level_options,
                'value' => function ($model) use ($access_level_options) {
                    return $access_level_options[$model->access_level];
                },
            ],
            // Add additional columns as needed
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}', // Allow to delete all users because they technically are all employees
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>