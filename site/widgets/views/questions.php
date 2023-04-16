<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap5\Alert;
use yii\widgets\MaskedInput;

$f = ActiveForm::begin([
    'action' => ['question/anketa-form-processing'],
    'options' => [
        'class' => "questions-form",
    ]
]);
?>

    <h2>Опросник</h2>
    <?php if ($m->hasErrors()):?>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert-danger',
            ],
            'body' => 'Что-то пошло не так',
        ]) ?>
    <?php endif; ?>
    <div class="row">
         <div class="col">Некий вопрос опросника..</div>
    </div>
    <div class="row">
        <?php foreach ($m->activeAttributes() as $attr):
            $el = $f->field($m, $attr, ['options' => ['class' => 'col-sm-6 col-lg-4' ]]);
            switch ($attr) {
                case 'rate':
                    $el->dropDownList(array_combine(range(1, 10), range(1, 10)) );
                    break;
                case 'sex':
                    $el->radioList($m::SEX_ENUM, ['class' => 'd-flex']);
                    break;
                case 'phone':
                    $el->widget(MaskedInput::class, ['mask' => '+7(999) 999-99-99']);
            } ?>
            <?= $el ?>
        <?php endforeach; ?>
        <div class="col-sm-6 col-lg-4 mt-4"><?= Html::submitButton('Отправить', ['class' => 'btn btn-primary mt-2']); ?></div>
    </div>
    <div class="row">
        <div class="col-sm-6 text-center mt-3"></div>
    </div>

<?php ActiveForm::end(); ?>