<?php

class m150714_071443_news_url extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `news`
            ADD `url` varchar(100) COLLATE 'utf8_general_ci' NULL AFTER `full_text`;
        ");
	}

	public function down()
	{
        $this->execute("
            ALTER TABLE `news` DROP `url`;
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