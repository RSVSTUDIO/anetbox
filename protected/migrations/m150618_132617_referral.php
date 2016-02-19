<?php

class m150618_132617_referral extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_instruments`
            ADD `referral` varchar(250) COLLATE 'utf8_general_ci' NULL;
        ");
        $this->execute("
            UPDATE `user_instruments` SET `referral` = 'http://teasernet.com/?owner_id=201293' WHERE `id` = '5';
            UPDATE `user_instruments` SET `referral` = 'http://partner.directadvert.ru/?ref=224686' WHERE `id` = '6';
            UPDATE `user_instruments` SET `referral` = 'https://www.admitad.com/ru/promo/?ref=575ffc9395' WHERE `id` = '9';
            UPDATE `user_instruments` SET `referral` = 'http://actionteaser.ru/r/10872' WHERE `id` = '13';
        ");
	}

	public function down()
	{
		echo "m150618_132617_referral does not support migration down.\n";
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