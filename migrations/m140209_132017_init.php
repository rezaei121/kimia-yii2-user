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
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class m140209_132017_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id'                   => $this->bigInteger()->primaryKey(),
            'username'             => $this->string(25)->notNull(),
            'email'                => $this->string(255)->notNull(),
            'password_hash'        => $this->string(60)->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'confirmation_token'   => $this->string(32)->null(),
            'confirmation_sent_at' => $this->integer()->null(),
            'confirmed_at'         => $this->integer()->null(),
            'unconfirmed_email'    => $this->string(255)->null(),
            'recovery_token'       => $this->string(32)->null(),
            'recovery_sent_at'     => $this->integer()->null(),
            'blocked_at'           => $this->integer()->null(),
            'registered_from'      => $this->integer()->null(),
            'logged_in_from'       => $this->integer()->null(),
            'logged_in_at'         => $this->integer()->null(),
            'created_at'           => $this->integer()->notNull(),
            'updated_at'           => $this->integer()->notNull(),
        ], $this->tableOptions);

        $this->createIndex('{{%user_unique_username}}', '{{%user}}', 'username', true);
        $this->createIndex('{{%user_unique_email}}', '{{%user}}', 'email', true);
        $this->createIndex('{{%user_confirmation}}', '{{%user}}', 'id, confirmation_token', true);
        $this->createIndex('{{%user_recovery}}', '{{%user}}', 'id, recovery_token', true);

        $this->createTable('{{%profile}}', [
            'user_id'        => $this->integer()->notNull()->append('PRIMARY KEY'),
            'name' => $this->string(25)->comment('نام'),
            'lastname' => $this->string(35)->comment('نام خانوادگی'),
            'sexuality_code' => $this->bigInteger()->comment('جنسیت'),
            'nationality_code' => $this->bigInteger()->comment('ملیت'),
            'phone_number' => $this->string(15)->comment('شماره تلفن'),
            'birthday' => $this->date()->comment('تاریخ تولد'),
            'country_id' => $this->bigInteger(),
            'province_id' => $this->bigInteger(),
            'city_id' => $this->bigInteger(),
            'address' => $this->string(125)->comment('آدرس'),
            'zip_code' => $this->string(15)->comment('کد پستی'),
            'father_name' => $this->string(25)->comment('نام پدر'),
            'educational_level' => $this->bigInteger()->comment('سطح تحصیلات'),
            'study_field' => $this->bigInteger()->comment('رشته تحصیلی'),
            'job' => $this->string(35)->comment('شغل'),
            'location_home' => $this->string()->comment('موقعیت محل اقامت بر روی نقشه'),
            'language_id' => $this->bigInteger()->comment('زبان'),
            'religion' => $this->bigInteger()->comment('دین'),
            'faith' => $this->bigInteger()->comment('مذهب'),
            'pic' => $this->string()->comment('تصویر'),
            'personality_type' => $this->bigInteger()->comment('نوع شخصیت'),
            'tourist_code' => $this->string()->comment('کد گردشگری'),
            'personality_type_legal_name' => $this->string(75)->comment('نام شخصیت حقوقی'),
            'personality_type_legal' => $this->bigInteger()->comment('شخصیت حقوقی دولتی/خصوصی'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_user_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'updated_user_id' => $this->bigInteger(),
            'deleted_at' => $this->timestamp(),
            'deleted_user_id' => $this->bigInteger(),
        ], $this->tableOptions);

        $this->addForeignKey('fk_profile_user_profile', '{{%profile}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);
        $this->addForeignKey('fk_profile_sexuality_code', '{{%profile}}', 'sexuality_code', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_nationality_code', '{{%profile}}', 'nationality_code', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_educational_level', '{{%profile}}', 'educational_level', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_study_field', '{{%profile}}', 'study_field', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_religion', '{{%profile}}', 'religion', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_faith', '{{%profile}}', 'faith', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_personality_type', '{{%profile}}', 'personality_type', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_personality_type_legal', '{{%profile}}', 'personality_type_legal', '{{%domain}}', 'id');
        $this->addForeignKey('fk_profile_country_id', '{{%profile}}', 'country_id', '{{%administrative_division}}', 'id');
        $this->addForeignKey('fk_profile_province_id', '{{%profile}}', 'province_id', '{{%administrative_division}}', 'id');
        $this->addForeignKey('fk_profile_city_id', '{{%profile}}', 'city_id', '{{%administrative_division}}', 'id');
        $this->addForeignKey('fk_profile_language_id', '{{%profile}}', 'language_id', '{{%language}}', 'id');
        $this->addForeignKey('fk_profile_created_user_id', '{{%transportation_car_company_equipment_translation}}', 'created_user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_profile_updated_user_id', '{{%transportation_car_company_equipment_translation}}', 'updated_user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_profile_deleted_user_id', '{{%transportation_car_company_equipment_translation}}', 'deleted_user_id', '{{%user}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }
}
