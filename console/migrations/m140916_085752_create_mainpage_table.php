<?php

class m140916_085752_create_mainpage_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('otherproperties', array(
                'properties' => 'varchar(255) NOT NULL',
                'value' => 'varchar(255) NULL',
                'PRIMARY KEY (properties)',
            ),
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );

        $this->createTable('design', array(
                'post_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'anounce'   => 'TEXT NOT NULL',
                'content' => 'LONGTEXT',
                'publication_date' => 'DATETIME NOT NULL',
                'is_top' => 'TINYINT(1) NOT NULL DEFAULT 0',
                'is_slider' => 'TINYINT(1) NOT NULL DEFAULT 0',
                'user_id' => 'INT(11) UNSIGNED NOT NULL',
                'category' => 'TINYINT(4) NOT NULL',
                'PRIMARY KEY (post_id)',
            ),
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );

        $this->createTable('category', array(
                'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'category' => 'varchar(255) NOT NULL',
                'number' => 'INT(11) NULL',
                'PRIMARY KEY (id)',
            ),
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
    }

    public function safeDown()
    {
        $this->dropTable('category');
        $this->dropTable('design');
        $this->dropTable('otherproperties');

    }
}