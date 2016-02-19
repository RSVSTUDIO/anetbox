<?php

class m150615_112648_driver_action_teaser extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET
            `cpa` = '1',
            `cpc` = '1',
            `cpv` = NULL
            WHERE `id` = '13';
        ");
	}

	public function down()
	{
		echo "m150615_112648_driver_action_teaser does not support migration down.\n";
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