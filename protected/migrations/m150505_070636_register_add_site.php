<?php

class m150505_070636_register_add_site extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_invite`
            ADD `site_1` varchar(100) NULL,
            ADD `site_2` varchar(100) NULL AFTER `site_1`,
            ADD `site_3` varchar(100) NULL AFTER `site_2`;
        ");
	}

	public function down()
	{
        $this->execute("
            ALTER TABLE `user_invite`
            DROP `site_1`,
            DROP `site_2`,
            DROP `site_3`;
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