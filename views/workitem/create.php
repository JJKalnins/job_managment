<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Work Item';
$this->params['breadcrumbs'][] = ['label' => 'Work items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="work_item-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'default_comment')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>