<?php

class m130801_114704_create_tbl_magazine extends CDbMigration
{
	public function up()
	{
        $this->createTable('magazine', array(
                'magazine_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'gallery_id' => 'INT(11) UNSIGNED',
                'filename'   => 'varchar(255)',
                'is_shown' => 'TINYINT(1) DEFAULT 1',
                'PRIMARY KEY (magazine_id)',
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
        $this->addForeignKey('FK_magizine_gallery', 'magazine', 'gallery_id', 'gallery', 'gallery_id');
	}

	public function down()
	{
        $this->dropTable('magazine');
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