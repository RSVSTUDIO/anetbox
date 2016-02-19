<?php

class m150708_040038_Driver_Litres extends EDbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `user_instruments` (`title`, `description`, `url`, `cpa`, `cpc`, `cpv`, `driver`, `signature`, `referral`)
            VALUES ('Litres', NULL, 'litres.ru', NULL, NULL, NULL, 'DriverLitresHtmlParser', NULL, NULL);
        ");
	}

	public function down()
	{
		echo "m150708_040038_Driver_Litres does not support migration down.\n";
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