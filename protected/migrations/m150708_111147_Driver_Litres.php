<?php

class m150708_111147_Driver_Litres extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments` SET `cpa` = '1' WHERE `id` = '14';
        ");
	}

	public function down()
	{
		echo "m150708_111147_Driver_Litres does not support migration down.\n";
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