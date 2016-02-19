<?php

class m150528_172146_driver_google_adsense extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET `driver` = 'DriverGoogleAdSense' WHERE `id` = '4';
        ");
	}

	public function down()
	{
		echo "m150528_172146_driver_google_adsense does not support migration down.\n";
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