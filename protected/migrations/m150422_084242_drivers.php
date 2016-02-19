<?php

class m150422_084242_drivers extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET `driver` = 'DriverAnetBOX' WHERE `id` = '1';
            UPDATE `user_instruments` SET `driver` = 'DriverTeaserNET' WHERE `id` = '5';
            UPDATE `user_instruments` SET `driver` = 'DriverAdmitAd' WHERE `id` = '9';
        ");
	}

	public function down()
	{
        $this->execute("
            UPDATE `user_instruments` SET `driver` = NULL WHERE `id` IN ('1','5','9');
        ");
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