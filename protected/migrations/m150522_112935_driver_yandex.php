<?php

class m150522_112935_driver_yandex extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET `title` = 'Yandex Metrika', `url` = 'metrika.yandex.ru', `driver` = 'DriverYandexMetrika' WHERE `id` = '11';
        ");
        $this->execute("
            ALTER TABLE `user_instruments_cron_log`
            RENAME TO `user_instruments_log`;
        ");
	}

	public function down()
	{
		echo "m150522_112935_driver_yandex does not support migration down.\n";
		return false;
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