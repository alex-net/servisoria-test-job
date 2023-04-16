<?php

namespace app\components;

use yii\i18n\Formatter;
use yii\helpers\Html;

use app\models\Question;

class SiteFormatter extends Formatter
{
    /**
     * Форматирование телефонного номера
     */
    public function asPhone($val)
    {
        $valNul = '+' . $val;
        $format = [1, ' (', 3, ') ', 3, '-', 2, '-', 2, ''];
        $nums = [];
        for ($i = 0; $i < count($format); $i += 2) {
            $nums[] = substr($val, 0, $format[$i]);
            $val = substr($val, $format[$i]);
            $nums[] = $format[$i + 1];
        }
        array_unshift($nums, '+');

        return  Html::a(implode('', $nums), 'tel:' . $valNul);
    }

    /**
     * Формтатирование вывода пола
     */
    public function asSex($val)
    {
        return Question::SEX_ENUM[$val] ?? '-';
    }

    /**
     * отображение рейтига ..
     *
     * @param      <type>  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function asRatingStar($val)
    {
        return Html::tag('span', str_repeat('*', intval($val)), ['title' => $val]);
    }

}