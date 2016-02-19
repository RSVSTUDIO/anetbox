<?php

class m150411_140344_site_data extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `profile`
            ADD `company` varchar(255) COLLATE 'utf8_general_ci' NULL,
            ADD `company_site` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `company`;
        ");
	}

	public function down()
	{
		echo "m150411_140344_site_data does not support migration down.\n";
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