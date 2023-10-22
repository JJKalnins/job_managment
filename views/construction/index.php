<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consatruction Site List';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="construction-index">
    <?= Html::a('Create Construction Site', ['construction/create'], ['class' => 'btn btn-primary']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'location',
            'sqsize',
            [
                'attribute' => 'required_access_level',
                'filter' => $access_level_options,
                'value' => function ($model) use ($access_level_options) {
                    return $access_level_options[$model->required_access_level];
                },
            ],
            // Add additional columns as needed
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>