<?php

class m130731_142831_add_gallery extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->createTable('gallery', array(
                'gallery_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'title'   => 'varchar(255) NOT NULL',
                'description' => 'TEXT DEFAULT NULL',
                'is_active' => 'TINYINT(1) NOT NULL DEFAULT 1',
                'PRIMARY KEY (gallery_id)',
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
        $this->createTable('photo', array(
                'photo_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'gallery_id' => 'INT(11) UNSIGNED NOT NULL',
                'title'   => 'varchar(255) NOT NULL',  
                'filename' => 'varchar(255) NOT NULL',
                'thumb_filename' => 'varchar(255) NOT NULL',
                'description' => 'VARCHAR(255) NOT NULL',
                'mime_type' => 'VARCHAR(32) NOT NULL',
                'sort_order' => 'INT(10) DEFAULT NULL',
                'is_top' => 'TINYINT(1) NOT NULL DEFAULT 1',
                'PRIMARY KEY (photo_id)',
                //'REFERENCES gallery (gallery_id) ON DELETE RESTRICT ON UPDATE RESTRICT'
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
        $this->addForeignKey('FK_photo_gallery', 'photo', 'gallery_id', 'gallery', 'gallery_id', 'RESTRICT', 'RESTRICT');
	}

	public function safeDown()
	{
        $this->dropTable('photo');
        $this->dropTable('gallery');
	}
}