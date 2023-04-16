<?php

namespace app\models;

use yii\base\Model;
use yii\db\Query;
use yii\db\Expression;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

class Question extends Model
{
    const SCENARIO_AS_FILTER = 'filter';
    const SEX_ENUM = ['male' => 'муж.', 'famale' => 'жен.'];

    public $name, $email, $phone, $region, $city, $sex, $rate, $comment, $date;

    private $parsedDateRange;

    public function scenarios()
    {
        $sc = parent::scenarios();
        $sc[static::SCENARIO_AS_FILTER] = ['sex', 'region', 'city', 'date'];
        return $sc;
    }

    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'region', 'city', 'sex', 'rate', 'comment'], 'required', 'on' => static::SCENARIO_DEFAULT],
            ['comment', 'string'],
            ['sex', 'in', 'range' => array_keys(static::SEX_ENUM)],
            ['rate', 'integer', 'min' => 1, 'max' => 10],
            ['rate', 'default', 'value' => 10],
            [['name', 'email', 'region', 'city', ], 'string', 'max' => 75],
            ['email', 'email'],
            ['date', 'string', 'on' => static::SCENARIO_AS_FILTER ],
            ['date', 'detectDate', 'on' => static::SCENARIO_AS_FILTER],
            ['phone', 'match', 'pattern' => '#^\+7\(\d{3}\) \d{3}-\d{2}-\d{2}$#'],
            // ['phone', 'string', 'max' => 11],
        ];
    }

    public function detectDate($attr)
    {
        $val = trim($this->$attr);
        if (!preg_match('#^(\d{2}/\d{2}/\d{4}) - (\d{2}/\d{2}/\d{4})$#', $val, $dates)) {
            $this->addError($attr, 'Некорректный диапазон дат');
            return;
        }
        array_shift($dates);
        $dates = array_map('strtotime', $dates);
        if ($dates[0] > $dates[1]) {
            $dates = array_reverse($dates);
        }
        $dates = array_map(function($v){
            return date('Y-m-d', $v);
        }, $dates);

        $this->parsedDateRange = $dates;

    }


    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email' ,
            'phone' => 'Телефон',
            'region' => 'Регион',
            'city' => 'Город',
            'sex' => 'Пол',
            'date' => 'Дата',
            'rate' => 'Оценка',
            'comment' => 'Комментарий',
        ];
    }

    /**
     * сохранение данных клиента
     *
     * @param      array  $data   Post запрос
     */
    public function saveAnswer(array $data)
    {
        if ($data && !$this->load($data) || !$this->validate()) {
            return false;
        }

        $attrs = $this->getAttributes($this->activeAttributes());
        $attrs['phone'] = preg_replace('#\D+#', '', $attrs['phone']);
        Yii::$app->db->createCommand()->insert('{{%questions}}', $attrs)->execute();

        return true;
    }

    public function loadFromGet(array $data)
    {
        foreach ($this->activeAttributes() as $field) {
            if (isset($data[$field])) {
                $this->$field = $data[$field];
            }
        }
        if (!$this->validate()) {
            foreach (array_keys($this->errors) as $field) {
                $this->$field = null;
            }
        }
    }

    /**
     * вернуть фильрующий запрос
     *
     * @return     Query  The filter query.
     */
    private function getFilterQuery()
    {
        $q = new Query();
        $q->from('{{%questions}}');

        // фильтр по дате
        if ($this->parsedDateRange) {
            $q->andWhere(['between', 'date', $this->parsedDateRange[0], $this->parsedDateRange[1]]); ;
        }
        $q->andFilterWhere(['sex' => $this->sex]);
        $q->andFilterWhere(['like', 'city', $this->city]);
        $q->andFilterWhere(['like', 'region', $this->region]);
        return $q;
    }

    /**
     * формируем список для табличного отображеня данных ....
     */
    public function getList()
    {
        $cmd = $this->getFilterQuery()->createCommand();

        return new SqlDataProvider([
            'sql' => $cmd->sql,
            'params' => $cmd->params,
            'sort' => [
                'attributes' => ['rate', 'date', 'name'],
                'defaultOrder' => ['date' => SORT_DESC],
            ],
        ]);
    }

    /**
     * даные для дашбоардов ....
     *
     * @param      string  $groupedField  поле для просчёта статистики ...
     */
    public function getDashBoardData($groupedField)
    {
        static $co;
        $q = $this->getFilterQuery();
        if (!isset($co)) {
            $co = $q->count();
        }

        $q->groupBy($groupedField);
        $q->select(['title' => $groupedField, 'co' => new Expression('count(*)')]);
        $list = $q->all();
        if ($groupedField == 'sex') {
            foreach ($list as $x => $y) {
                $list[$x]['title'] = Yii::$app->formatter->asSex($y['title']);
            }
        }
        $list = ArrayHelper::map($list, 'title', 'co');

        foreach ($list as $title => $lco) {
            unset($list[$title]);
            $list[$title . ' '] = sprintf('%d (%0.2f%%)', $lco, $lco/$co*100);
        }

        $list = array_merge([' Всего по ' . $this->getAttributeLabel($groupedField) => $co], $list);

        return $list;
    }

    /**
     * получить данные для построения графиков ..(зависимость от даты)
     *
     * @param      string  $field  Поле для построения графика
     *
     * @return     array  певое значение = сами данные, второе значение = описания значений ...
     */
    public function getGraphicsData($field)
    {
        // определиться с доступными значениями по полю ... (число кривых )
        $q = $this->getFilterQuery();
        $q->distinct();
        $q->select($field);
        $q->orderBy($field);
        $varList = $q->column();

        $q = $this->getFilterQuery();
        $q->groupBy('date');
        $q->indexBy('date');
        $fields = ['date'];
        foreach ($varList as $ind => $val) {
            $fields['line' . $ind] = new Expression("sum(case when [[$field]] = :val$ind then 1 else 0 end)", [':val' . $ind => $val]);
        }
        $q->select($fields);

        $list = array_map(function ($v) {
            unset($v['date']);
            return $v;
        }, $q->all());

        if ($field == 'sex') {
            $varList = array_map(function($v) {
                return static::SEX_ENUM[$v];
            }, $varList);
        }

        return [$list, $varList];
    }

}