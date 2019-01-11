<?php

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Task
 *
 * @property $id         int
 * @property $text       string
 * @property $up_to      int
 * @property $status     int
 * @property $created_at int
 */
class Task extends ActiveRecord
{
    const STATUS_DONE = 1;
    const STATUS_REJECTED = 2;

    const STATUSES_LABELS = [
        self::STATUS_DONE => 'Выполнена',
        self::STATUS_REJECTED =>  'Отколнена'
    ];

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ],
        ];
    }

    public static function create($text, $upTo)
    {
        $task = new self();
        $task->text = $text;
        $task->up_to = $upTo;

        return $task;
    }

    public function getStatus()
    {
        return time() > $this->up_to ? self::STATUS_REJECTED : $this->status;
    }
}