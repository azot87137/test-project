<?php

namespace app\controllers;

use app\forms\TaskCreateForm;
use app\models\Task;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => $this->getDataProvider()
        ]);
    }

    public function actionCreate()
    {
        $form = new TaskCreateForm();

        if ($form->load(Yii::$app->getRequest()->post()) && $form->validate()) {
            $task = Task::create($form->text, strtotime($form->upTo));
            $task->save();

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $form
        ]);
    }

    public function actionDelete($id)
    {
        $task = Task::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();

        if (empty($task)) {
            throw new NotFoundHttpException('Задача не найдена.');
        }

        $task->delete();

        if (Yii::$app->getRequest()->isPjax) {
            return $this->renderAjax('_grid', ['dataProvider' => $this->getDataProvider()]);
        }

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteByIds()
    {
        return $this->handleGroupRequest(function ($task) {
            return $task->delete();
        });
    }

    public function actionMarkAsDone()
    {
        return $this->handleGroupRequest(function ($task) {
             $task->status = Task::STATUS_DONE;

             return $task->save();
        });
    }

    public function actionMarkAsRejected()
    {
        return $this->handleGroupRequest(function ($task) {
            $task->status = Task::STATUS_REJECTED;

            return $task->save();
        });
    }

    /**
     * @param callable $action
     *
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    protected function handleGroupRequest(callable $action)
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }

        $ids = Yii::$app->request->post('ids', []);

        if (!is_array($ids)) {
            throw new InvalidParamException('Параметр "ids" не массив');
        }

        $deleted = 0;

        $tasks = Task::find()->where(['id' => $ids])->all();

        foreach ($tasks as $task) {
            if ($action($task)) {
                $deleted++;
            }
        }

        return $this->asJson([
            'status' => true,
            'message' => "В результате было затронуто задач - $deleted",
        ]);
    }

    protected function getDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Task::find(),
            'sort'  => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]
        ]);
    }
}
