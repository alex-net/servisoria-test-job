<?php

namespace app\controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\bootstrap5\Alert;
use yii\web\Cookie;
use yii\web\Response;
use yii\helpers\Html;
use Yii;

use app\models\Question;
use app\widgets\QuestionsWidget;

class QuestionController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::class,
                'rules' => [
                    ['actions' => ['anketa-form-processing'], 'allow' => true, 'verbs' => ['post']],
                    ['actions' => ['list', 'export'], 'allow' => true, 'roles' => ['@']],
                ],
            ]
        ];
    }


    private function appliGetQuery()
    {
        $filterModel = new Question(['scenario' => Question::SCENARIO_AS_FILTER]);
        $filterModel->loadFromGet($this->request->get());
        return $filterModel;
    }

    /**
     * обработка данных формы ..
     */
    public function actionAnketaFormProcessing()
    {
        $form = new Question();

        if (!$form->saveAnswer($this->request->post())) {
            return QuestionsWidget::widget(['model' => $form]);
        }

        $this->response->cookies->add(new Cookie(['name' => 'question-passed', 'value' => 1]));

        return Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => 'Спасибо за оставленный ответ. Мы обязательно учтём Ваше мнение.',
        ]);
    }


    /**
     * список результатов опроса ..
     */
    public function actionList()
    {
        return $this->render('quest-list', [
            'filterModel' => $this->appliGetQuery(),
        ]);
    }

    /**
     * действие экспорта с учётом фильтра ...
     */
    public function actionExport()
    {
        $model = $this->appliGetQuery();
        $dp = $model->getList();
        $dp->pagination = false;
        $date = $dp->models;

        if (!$date) {
            Yii::$app->session->addFlash('info', 'Список пуст');
            return $this->redirect(array_merge(['list',], $this->request->get()));
        }

        $file = tmpfile();
        $mdArray = stream_get_meta_data($file);


        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $cols = array_keys($date[0]);
        foreach ($cols as $col => $field) {
            $activeWorksheet->setCellValue([$col + 1, 1], $model->getAttributeLabel($field));
        }
        for ($row = 0; $row < count($date); $row++) {
            foreach ($cols as $col => $field) {
                $val = $date[$row][$field];
                if ($field == 'sex') {
                    $val = Yii::$app->formatter->asSex($val);
                }
                $activeWorksheet->setCellValue([$col + 1, $row + 2], $val);
            }
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save($mdArray['uri']);

        return $this->response->sendFile($mdArray['uri'], 'export.xlsx');
    }
}