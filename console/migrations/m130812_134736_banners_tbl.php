<?php

class m130812_134736_banners_tbl extends CDbMigration
{
	public function up()
	{
        $this->createTable('banners', array(
                'banner_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'title' => 'VARCHAR(255) NOT NULL',
                'link' => 'TEXT  NOT NULL',
                'gallery_id' => 'INT(11) UNSIGNED NOT NULL',
                'is_active' => 'TINYINT(1) NOT NULL DEFAULT 1',
                'PRIMARY KEY (banner_id)',
            ),
            'ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );
	}

	public function down()
	{
        $this->dropTable('banners');
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