<?php

use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;

/* @var $model \app\forms\TaskCreateForm */

$this->title = 'Создать';

$this->params['breadcrumbs'][] = ['label' => 'TODO List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-create-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 7]) ?>

    <?= $form->field($model, 'upTo')->widget(DateTimePicker::className(), [
            'pluginOptions' => [
              'format' => 'dd-mm-yyyy hh:ii'
            ]
    ]) ?>

    <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>

</div>
