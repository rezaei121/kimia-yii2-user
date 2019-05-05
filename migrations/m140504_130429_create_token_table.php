<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use rezaei121\user\migrations\Migration;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class m140504_130429_create_token_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%token}}', [
            'user_id'    => $this->bigInteger()->notNull(),
            'code'       => $this->string(32)->notNull(),
            'app_name'       => $this->string(32)->notNull(),
            'platform'       => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        $this->createIndex('{{%token_unique}}', '{{%token}}', ['user_id', 'code', 'app_name', 'platform'], true);
        $this->addForeignKey('{{%fk_user_token}}', '{{%token}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);
    }

    public function down()
    {
        $this->dropTable('{{%token}}');
    }
}
