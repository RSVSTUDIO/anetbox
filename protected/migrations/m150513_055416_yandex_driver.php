<?php

class m150513_055416_yandex_driver extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET
            `driver` = 'DriverYandex'
            WHERE `id` = '11';
        ");
	}

	public function down()
	{
        $this->execute("
            UPDATE `user_instruments` SET
            `driver` = NULL
            WHERE `id` = '11';
        ");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}