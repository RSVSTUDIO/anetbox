<?php

class m150505_093057_register_add_site extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_invite`
            CHANGE `site_1` `sites` text COLLATE 'utf8_general_ci' NULL AFTER `updated_by`,
            DROP `site_2`,
            DROP `site_3`;
        ");
	}

	public function down()
	{
		echo "m150505_093057_register_add_site does not support migration down.\n";
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