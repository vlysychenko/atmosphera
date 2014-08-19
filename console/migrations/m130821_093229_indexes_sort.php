<?php

class m130821_093229_indexes_sort extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	    $this->createIndex('IX_news_publication_date', 'news', 'publication_date');
        $this->createIndex('IX_galleryposts_publication_date', 'galleryposts', 'publication_date');  
    }

	public function safeDown()
	{
        $this->dropIndex('IX_news_publication_date', 'news');
        $this->dropIndex('IX_galleryposts_publication_date', 'galleryposts');  
 	}
	
}