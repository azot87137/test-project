<?php

use yii\helpers\ArrayHelper;
use app\models\Task;
use kartik\grid\GridView;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        ['class' => 'kartik\grid\CheckboxColumn'],
        [
            'label'     => 'Текст',
            'attribute' => 'text'
        ],
        [
            'label'     => 'Статус',
            'attribute' => 'status',
            'value' => function (Task $model) {
                return ArrayHelper::getValue(Task::STATUSES_LABELS, $model->getStatus());
            }
        ],
        [
            'label'     => 'Актуально до',
            'attribute' => 'up_to',
            'format'    => 'datetime'
        ],
        [
            'label'     => 'Добавлена',
            'attribute' => 'created_at',
            'format'    => 'datetime'
        ],
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttonOptions' => [
                'data-pjax' => 1
            ]
        ],
    ],
    'pjax'         => true,
    'pjaxSettings' => [
        'neverTimeout' => true,
        'options' => [
            'id' => 'tasks-pjax',
        ],
    ]
]) ?>
