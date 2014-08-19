<?php

class m130821_095606_indexes_sort3 extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        //$this->update('partners', array('order_nr'=>'partner_id'));
        Yii::app()->db->createCommand('UPDATE partners SET order_nr = partner_id')->execute();
        $this->createIndex('UK_partners', 'partners', 'order_nr', true);
	}

	public function safeDown()
	{
        $this->dropIndex('UK_partners', 'partners');
	}
	
}