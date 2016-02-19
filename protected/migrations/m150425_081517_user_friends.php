<?php

class m150425_081517_user_friends extends EDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE IF EXISTS `user_friend`;
            CREATE TABLE `user_friend` (
              `user_id` int(11) DEFAULT NULL,
              `friend_id` int(11) DEFAULT NULL,
              `accept` enum('y','n') NOT NULL DEFAULT 'n',
              UNIQUE KEY `user_id_banned_id` (`user_id`,`friend_id`),
              KEY `user_id` (`user_id`),
              KEY `friend_id` (`friend_id`),
              CONSTRAINT `user_friend_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
              CONSTRAINT `user_friend_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function down()
	{
        $this->execute("DROP TABLE IF EXISTS `user_friend`;");
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