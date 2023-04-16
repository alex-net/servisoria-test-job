<?php

use yii\widgets\DetailView;
use yii\bootstrap5\Accordion;

use app\filterModels\Question;

$this->title = 'Результаты опроса';


echo Accordion::widget([
    'autoCloseItems' => false,
    'items' => [
        [
            'label' => 'Распределения',
            'content' => $this->render('distributions', compact('filterModel')),
        ], [
            'label' => 'Графики',
            'content' => $this->render('graphs', compact('filterModel')),

        ], [
            'label' => 'Вся таблица',
            'content' => $this->render('grid', compact('filterModel')),
            'expand' => true,
        ]
    ],
]);
