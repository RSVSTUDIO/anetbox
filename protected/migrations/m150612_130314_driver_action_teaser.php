<?php

class m150612_130314_driver_action_teaser extends EDbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `user_instruments` (`title`, `description`, `url`, `cpa`, `cpc`, `cpv`, `driver`, `signature`)
            VALUES ('Action Teaser', NULL, 'actionteaser.ru', NULL, NULL, NULL, 'DriverActionTeaser', NULL);
        ");
	}

	public function down()
	{
		echo "m150612_130314_driver_action_teaser does not support migration down.\n";
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