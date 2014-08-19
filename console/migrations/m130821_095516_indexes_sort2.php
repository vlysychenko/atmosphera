<?php

class m130821_095516_indexes_sort2 extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        //$this->createIndex('IX_photo', 'photo', 'gallery_id, sort_order');
        $this->createIndex('UK_magazine', 'magazine', 'publication_year, publication_month', true);  
	}

	public function safeDown()
	{
        //$this->dropIndex('IX_photo', 'photo');
        $this->dropIndex('UK_magazine', 'magazine');  
	}
	
}