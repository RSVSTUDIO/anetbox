<?php

class m150605_043102_yandex_html_parser extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET
            `title` = 'Yandex Partner',
            `url` = 'partner.yandex.ru',
            `driver` = 'DriverYandexHtmlParser'
            WHERE `id` = '11';
        ");
	}

	public function down()
	{
		echo "m150605_043102_yandex_html_parser does not support migration down.\n";
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