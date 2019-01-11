<?php

namespace app\forms;


use yii\base\Model;

class TaskCreateForm extends Model
{
    public $text;
    public $upTo;

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string', 'max' => 1000],
            [['upTo'], 'required'],
            [['upTo'], 'datetime', 'format' => 'd-MM-yyyy H:mm']
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Текст задачи',
            'upTo' => 'Актуально до'
        ];
    }
}