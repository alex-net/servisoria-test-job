<?php

use app\widgets\GraphWidget;

?>
<div class="row">
    <div class="col g1" style="height: 20em;">
        <?= GraphWidget::widget([
            'field' => 'rate',
            'fieldCapt' => '{*} звёзд',
            'sourceModel' => $filterModel,
            'caption' => 'Распределение оценок по дням',
        ]) ?>
    </div>
    <div class="col">
        <?= GraphWidget::widget([
            'field' => 'sex',
            'fieldCapt' => '{*} пол',
            'sourceModel' => $filterModel,
            'caption' => 'Распределение проголосовавших по половому признаку',
        ]) ?>
    </div>
</div>