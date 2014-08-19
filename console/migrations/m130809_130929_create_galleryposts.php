<?php

class m130809_130929_create_galleryposts extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('galleryposts', array(
                'post_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'anounce'   => 'TEXT NOT NULL',  
                'publication_date' => 'DATETIME NOT NULL',
                'is_top' => 'TINYINT(1) NOT NULL DEFAULT 0',
                'is_slider' => 'TINYINT(1) NOT NULL DEFAULT 0',
                'user_id' => 'INT(11) UNSIGNED NOT NULL',
                'PRIMARY KEY (post_id)',
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
        $this->addForeignKey('FK_galleryposts_post', 'galleryposts', 'post_id', 'posting', 'post_id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('FK_galleryposts_user', 'galleryposts', 'user_id', 'users',   'user_id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('galleryposts');
    }
}
