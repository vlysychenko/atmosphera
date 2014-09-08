<?php

class m140908_123427_add_table_category extends CDbMigration
{
	    public function up() {
        $this->createTable('category', array(
            'category_id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(50) NOT NULL',
            'PRIMARY KEY (category_id)'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down() {
        $this->dropTable('category');
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