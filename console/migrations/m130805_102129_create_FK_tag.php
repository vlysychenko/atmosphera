<?php

class m130805_102129_create_FK_tag extends CDbMigration
{
//	public function up()
//	{
//	}
//
//	public function down()
//	{
//		echo "m130805_102129_create_FK_tag does not support migration down.\n";
//		return false;
//	}


	// Use safeUp/safeDown to do migration with transaction
	public function up()
	{
        $transaction=$this->getDbConnection()->beginTransaction();
        try
        {
            $this->addForeignKey('FK_tagpost_posting', 'tagpost', 'post_id', 'posting', 'post_id');
            $this->addForeignKey('FK_tagpostwithtag', 'tagpost', 'tag_id', 'tag', 'tag_id');
            $transaction->commit();
        }
        catch(Exception $e)
        {
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollback();
            $this->down();
            return false;
        }

	}

	public function down()
	{
        $this->dropForeignKey('FK_tagpost_posting', 'tagpost');
        $this->dropForeignKey('FK_tagpost_tag', 'tagpost');
	}

}