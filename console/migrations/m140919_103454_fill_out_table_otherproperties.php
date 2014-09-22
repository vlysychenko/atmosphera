<?php

class m140919_103454_fill_out_table_otherproperties extends CDbMigration
{
	public function up()
	{
        $this->insert('otherproperties', array(
                'properties'=>'link_facebook'
            ));

        $this->insert('otherproperties', array(
                'properties'=>'link_vk'
            ));

        $this->insert('otherproperties', array(
                'properties'=>'news_for_main_page'
            ));

        $this->insert('otherproperties', array(
                'properties'=>'mainpage'
            ));
	}

	public function down()
	{
		echo "m140919_103454_fill_out_table_otherproperties does not support migration down.\n";
		return false;
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