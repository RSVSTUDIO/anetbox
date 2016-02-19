<?php

class m150701_045153_referral_admitad extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET `referral` = 'https://www.admitad.com/ru/promo/?ref=8ae3e0893c' WHERE `id` = '9';
        ");
	}

	public function down()
	{
		echo "m150701_045153_referral_admitad does not support migration down.\n";
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