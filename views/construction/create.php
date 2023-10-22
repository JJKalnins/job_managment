<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Construction site';
$this->params['breadcrumbs'][] = ['label' => 'Construction sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="construction-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'location')->textInput() ?>
    <?= $form->field($model, 'sqsize')->textInput() ?>
    <?= $form->field($model, 'required_access_level')->dropDownList(
        $access_level_options,
        ['prompt' => 'Select Access Level']
    ) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>