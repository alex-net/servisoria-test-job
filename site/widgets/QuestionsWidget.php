<?php

namespace app\widgets;

use yii\base\Widget;
use Yii;

use app\models\Question;
use app\assets\QuestionsWidgetAsset;

class QuestionsWidget extends Widget
{
    public $model;

    public function run()
    {
        $passed = Yii::$app->request->cookies->get('question-passed');
        if ($passed && $passed->value) {
            return '';
        }

        QuestionsWidgetAsset::register($this->view);
        $m = $this->model ?: new Question();

        return $this->render('questions', ['m' => $m]);
    }
}