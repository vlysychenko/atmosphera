<?php

class m140908_123603_add_column_category_id_to_news_gallary extends CDbMigration
{
	    public function up() {
        $this->addColumn('news', 'category_id', 'int(11) NOT NULL');
        $this->addColumn('galleryposts', 'category_id', 'int(11) NOT NULL');
    }

    public function down() {
        $this->dropColumn('news', 'category_id');
        $this->dropColumn('galleryposts', 'category_id');
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