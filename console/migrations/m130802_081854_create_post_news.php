<?php

class m130802_081854_create_post_news extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('posting', array(
                'post_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'title'   => 'varchar(255) NOT NULL',
                'description' => 'TEXT DEFAULT NULL',
                'post_type' => 'TINYINT(4) NOT NULL',
                'created_date' => 'DATETIME NOT NULL',
                'is_active' => 'TINYINT(1) NOT NULL DEFAULT 1',
                'gallery_id' => 'INT(11) UNSIGNED NOT NULL',
                'PRIMARY KEY (post_id)',
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
        $this->addForeignKey('FK_post_gallery', 'posting', 'gallery_id', 'gallery', 'gallery_id', 'RESTRICT', 'RESTRICT');
        
        $this->createTable('news', array(
                'post_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'anounce'   => 'TEXT NOT NULL',  
                'content' => 'LONGTEXT',
                'publication_date' => 'DATETIME NOT NULL',
                'is_top' => 'TINYINT(1) NOT NULL DEFAULT 0',
                'is_slider' => 'TINYINT(1) NOT NULL DEFAULT 0',
                'user_id' => 'INT(11) UNSIGNED NOT NULL',
                'PRIMARY KEY (post_id)',
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
        $this->addForeignKey('FK_news_user', 'news', 'user_id', 'users', 'user_id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('news');
        $this->dropTable('post');
    }
}