<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Create Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="employee-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'lastname')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'password')->textInput() ?>
    <?= $form->field($model, 'birthday')->widget(DatePicker::class, [
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeYear' => true,
            'changeMonth' => true,
            'yearRange' => '1920:' . date('Y'),
        ],
    ]) ?>

    <?= $form->field($model, 'access_level')->dropDownList(
        $access_level_options,
        ['prompt' => 'Select Access Level']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>