<?php

use yii\db\Migration;

use app\models\Question;
/**
 * Handles the creation of table `{{%questions}}`.
 */
class m230415_080721_create_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("create type Sex as enum ('male', 'famale')");
        $this->createTable('{{%questions}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->defaultExpression('current_date')->comment('дата опроса'),
            'name' => $this->string(75)->notNull()->comment('имя'),
            'email' => $this->string(75)->notNull()->comment('email'),
            'phone' => $this->string(11)->notNull()->comment('телефон'),
            'region' => $this->string(75)->notNull()->comment('регион'),
            'city' => $this->string(75)->notNull()->comment('город'),
            'sex' => 'Sex not null',
            'comment' => $this->string()->notNull()->comment('комментарий'),
            'rate' => $this->integer()->notNull()->comment('оценка'),
        ]);
        foreach (['date', 'name', 'email', 'phone', 'region', 'city', 'sex', 'rate', 'comment'] as $x) {
            $this->createIndex("questions-$x-ind", '{{%questions}}', [$x]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%questions}}');
        $this->execute('drop type Sex');
    }
}
