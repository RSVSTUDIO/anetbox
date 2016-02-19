<?php

class m150702_182118_DriverActionTeaserHtmlParser extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET
            `driver` = 'DriverActionTeaserHtmlParser'
            WHERE `id` = '13';
        ");
	}

	public function down()
	{
		echo "m150702_182118_DriverActionTeaserHtmlParser does not support migration down.\n";
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