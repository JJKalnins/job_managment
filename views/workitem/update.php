<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Work Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Work Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="work_item-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'default_comment')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>