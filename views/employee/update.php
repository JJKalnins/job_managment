<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Update Employee: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="employee-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'lastname')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>
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
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>