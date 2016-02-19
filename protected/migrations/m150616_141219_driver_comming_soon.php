<?php

class m150616_141219_driver_comming_soon extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET `driver` = 'DriverRepubler' WHERE `id` = '10';
            UPDATE `user_instruments` SET `driver` = 'DriverAdFox' WHERE `id` = '12';
        ");
	}

	public function down()
	{
		echo "m150616_141219_driver_comming_soon does not support migration down.\n";
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