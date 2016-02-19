<?php

class m150616_130708_driver_direct_advert extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET
            `driver` = 'DriverDirectAdvert'
            WHERE `id` = '6';
        ");
	}

	public function down()
	{
		echo "m150616_130708_driver_direct_advert does not support migration down.\n";
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