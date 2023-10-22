<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Construction site: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Construction sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="employee-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'location')->textInput() ?>
    <?= $form->field($model, 'sqsize')->textInput() ?>
    <?= $form->field($model, 'required_access_level')->dropDownList(
        $access_level_options,
        ['prompt' => 'Select Access Level']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>