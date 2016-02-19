<?php

class m150411_132524_site_data extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_instruments_data`
                CHANGE `pages` `pages` bigint(20) unsigned NULL AFTER `instrument_id`,
            CHANGE `users` `users` bigint(20) unsigned NULL AFTER `pages`,
            CHANGE `views` `views` bigint(20) unsigned NULL AFTER `users`,
            CHANGE `clicks` `clicks` bigint(20) unsigned NULL AFTER `views`,
            CHANGE `actions` `actions` bigint(20) unsigned NULL AFTER `clicks`;
            
            ALTER TABLE `user_instruments_data`
            ADD INDEX `pages` (`pages`),
            ADD INDEX `users` (`users`),
            ADD INDEX `views` (`views`),
            ADD INDEX `clicks` (`clicks`),
            ADD INDEX `actions` (`actions`);
            
            INSERT INTO `profile_field` (`id`, `profile_field_category_id`, `module_id`, `field_type_class`, `field_type_config`, `internal_name`, `title`, `description`, `sort_order`, `required`, `show_at_registration`, `editable`, `visible`, `created_at`, `created_by`, `updated_at`, `updated_by`, `ldap_attribute`, `translation_category`, `is_system`) VALUES
            (30,	1,	NULL,	'ProfileFieldTypeText',	'{\"minLength\":\"\",\"maxLength\":\"100\",\"validator\":\"\",\"default\":\"\",\"regexp\":\"\",\"regexpErrorMessage\":\"\"}',	'company',	'Company',	'',	800,	0,	0,	1,	1,	'2015-04-11 20:36:45',	1,	'2015-04-11 20:36:45',	1,	'',	'UserModule.models_Profile',	NULL),
            (31,	1,	NULL,	'ProfileFieldTypeText',	'{\"minLength\":\"\",\"maxLength\":\"255\",\"validator\":\"url\",\"default\":\"\",\"regexp\":\"\",\"regexpErrorMessage\":\"\"}',	'company_site',	'Company Site',	'',	800,	0,	0,	1,	1,	'2015-04-11 20:39:47',	1,	'2015-04-11 20:39:47',	1,	'',	'UserModule.models_Profile',	NULL);
        ");
	}

	public function down()
	{
		echo "m150411_132524_site_data does not support migration down.\n";
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