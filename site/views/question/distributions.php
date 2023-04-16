<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

echo Html::beginTag('div', ['class' => 'row']);
foreach (['sex', 'rate', 'region', 'city'] as $field) {
    echo DetailView::widget([
        'model' => $filterModel->getDashBoardData($field),
        'options' => ['class' => 'col'],
    ]);
}
echo Html::endTag('div');
