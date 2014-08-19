<?php

class m130823_073227_comment_module extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('comments', array(
                'comment_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'owner_name' => 'VARCHAR(50) NOT NULL',
                'owner_id'   => 'INT(11) UNSIGNED NOT NULL',  
                'parent_comment_id' => 'INT(11) UNSIGNED DEFAULT NULL',
                'creator_id' => 'INT(11) DEFAULT NULL',
                'user_name' => 'VARCHAR(128) DEFAULT NULL',
                'user_email' => 'VARCHAR(255) DEFAULT NULL',
                'comment_text' => 'TEXT DEFAULT NULL',
                'create_time' => 'DATETIME DEFAULT NULL',
                'update_time' => 'DATETIME DEFAULT NULL',
                'status' => 'TINYINT(1) NOT NULL DEFAULT 0',
                'PRIMARY KEY (comment_id)',
            ),
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
    }

    public function safeDown()
    {
        $this->dropTable('comments');
    }
    
}
