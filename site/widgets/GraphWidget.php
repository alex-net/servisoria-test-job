<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use Yii;

use app\assets\GraphWidgetAsset;

class GraphWidget extends Widget
{
    /**
     * поле построения зааисимоати от даты
     */
    public $field;

    /**
     * подпись на одной линии
     */
    public $fieldCapt;
    /**
     * заголовок графика
     */
    public $caption;

    /**
     * источник данных
     */
    public $sourceModel;

    public function run()
    {
        GraphWidgetAsset::register($this->view);

        list($data, $descr) = $this->sourceModel->getGraphicsData($this->field);

        $jsDataVarName = 'graphDataField' . $this->field;

        $this->view->registerJsVar($jsDataVarName, [
            'data' => $data,
            'caption' => $this->caption,
            'lineTitle' => $this->fieldCapt,
            'descr' => $descr,
        ]);

        return Html::tag('canvas', '', [
            'id' => $this->id,
            'class' => ['graph-' . $this->field . '-by-date', 'graph-widget-container'],
            'data-view-var' => $jsDataVarName,
        ]);
    }
}