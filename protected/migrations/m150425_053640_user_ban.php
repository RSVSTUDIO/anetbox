<?php

class m150425_053640_user_ban extends EDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE IF EXISTS `user_ban`;
            CREATE TABLE `user_ban` (
              `user_id` int(11) DEFAULT NULL,
              `banned_id` int(11) DEFAULT NULL,
              UNIQUE KEY `user_id_banned_id` (`user_id`,`banned_id`),
              KEY `banned_id` (`banned_id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `user_ban_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
              CONSTRAINT `user_ban_ibfk_2` FOREIGN KEY (`banned_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function down()
	{
        $this->execute("DROP TABLE IF EXISTS `user_ban`;");
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