<?php

class m140908_123659_add_fk_to_news extends CDbMigration
{
	    public function up() {
        $this->addForeignKey('fk_news_category', 'news', 'category_id', 'category', 'category_id', 'RESTRICT','RESTRICT');
         
        
    }

    public function down() {
        $this->dropForeignKey('fk_news_category', 'news');
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