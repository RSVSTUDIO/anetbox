<?php

class m150601_071520_earnings extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_instruments_data`
            ADD `earnings` decimal(10,2) unsigned NULL AFTER `actions`;
        ");
	}

	public function down()
	{
		echo "m150601_071520_earnings does not support migration down.\n";
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