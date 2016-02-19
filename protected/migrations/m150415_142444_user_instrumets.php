<?php

class m150415_142444_user_instrumets extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_instruments` ADD `signature` VARCHAR(60) AFTER `driver`;
        ");



	}

	public function down()
	{
        $this->execute("
            ALTER TABLE `user_instruments` DROP `signature`;
        ");

		echo "Column 'signature' DROPED!!!.\n";
		return true;
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