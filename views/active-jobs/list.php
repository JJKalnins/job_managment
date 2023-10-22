<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Work Item List';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="work_item-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $active_jobs,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            [
                'label' => "Construction site",
                'value' => function ($model) {
                    return $model->constructionSite->location;
                },
            ],
            [
                'label' => "Task",
                'value' => function ($model) {
                    return $model->workItem->name;
                },
            ],
            [
                'label' => "Comment",
                'value' => function ($model) {
                    return $model->workItem->default_comment;
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>