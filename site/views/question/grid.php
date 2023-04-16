<?php

use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

use app\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);
$js = <<<JS
    $('.datetimepicker-conrroll').daterangepicker({
        autoApply: true
    });
JS;


$exportUrl = array_merge(['export'], Yii::$app->request->get());
$links = Html::a('экспорт в xlsx', $exportUrl, ['class' => 'export-xlsx ms-3']);
$links .= ', &nbsp;' . Html::a('сброс фильтра', ['']);

echo GridView::widget([
    'layout' => "<div class='d-flex justify-content-start'>{summary}$links</div> {items} {pager}" ,
    'dataProvider' => $filterModel->getList(),
    'filterModel' => $filterModel,
    'columns' => [
        [
            'class' => SerialColumn::class,
        ],
        [
            'attribute' => 'date',
            'label' => $filterModel->getAttributeLabel('date'),
            'format' => 'date',
            'filter' => Html::input('text', 'date', $filterModel->date, ['class' => 'form-control datetimepicker-conrroll', 'readonly' => true]),
        ],
        'name:text:' . $filterModel->getAttributeLabel('name'),
        'email:email:' . $filterModel->getAttributeLabel('email'),
        'phone:phone:' . $filterModel->getAttributeLabel('phone'),
        [
            'attribute' => 'region',
            'label' =>  $filterModel->getAttributeLabel('region'),
            'filter' => Html::textInput('region', $filterModel->region, ['class' => 'form-control']),
        ],
        [
            'attribute' => 'city',
            'label' => $filterModel->getAttributeLabel('city'),
            'filter' => Html::textInput('city', $filterModel->city, ['class' => 'form-control']),
        ],
        [
            'attribute' => 'sex',
            'label' => $filterModel->getAttributeLabel('sex'),
            'format' => 'sex',
            'filter' => Html::dropDownList('sex', $filterModel->sex, $filterModel::SEX_ENUM, ['prompt' => '--', 'class' => 'form-control']),
        ],
        'comment:text:' . $filterModel->getAttributeLabel('comment'),
        'rate:ratingstar:' . $filterModel->getAttributeLabel('rate'),
    ],
]);

?>