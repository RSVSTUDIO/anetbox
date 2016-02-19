<?php

class m150413_175413_custom_page extends EDbMigration
{
	public function up()
	{
        $this->execute("TRUNCATE TABLE `custom_pages_page`;");
	}

	public function down()
	{
		echo "m150413_175413_custom_page does not support migration down.\n";
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