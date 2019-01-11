<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */

use app\assets\ListAsset;
use yii\helpers\Html;

ListAsset::register($this);

$this->title = 'TODO List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Удалить выделенное', ['site/delete-by-ids'], ['data' => ['group-request' => true], 'class' => 'btn btn-danger']) ?>

        <?= Html::a('Пометить как "Выполненая"', ['site/mark-as-done'], ['data' => ['group-request' => true], 'class' => 'btn btn-warning']) ?>

        <?= Html::a('Пометить как "Отколнена"', ['site/mark-as-rejected'], ['data' => ['group-request' => true], 'class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_grid', [
            'dataProvider' => $dataProvider
    ]) ?>
</div>
