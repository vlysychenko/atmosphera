 <?php

class m130805_091407_create_tabl_tag extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable('tag', array(
                'tag_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'title'   => 'varchar(255) NOT NULL',
                'PRIMARY KEY (tag_id)',
            ),
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );

        $this->createTable('tagpost', array(
                'tag_id' => 'INT(11) UNSIGNED NOT NULL',
                'post_id' => 'INT(11) UNSIGNED NOT NULL',
                'PRIMARY KEY (tag_id,post_id)',
            ),
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
    }

	public function safeDown()
	{
        $this->dropTable('tag');
        $this->dropTable('tagpost');
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