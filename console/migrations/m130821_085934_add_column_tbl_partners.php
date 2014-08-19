<?php

class m130821_085934_add_column_tbl_partners extends CDbMigration
{
	public function up()
	{
        $this->addColumn('partners', 'order_nr', 'INT(11) DEFAULT 0 NULL AFTER is_active');
	}

	public function down()
	{
        $this->dropColumn('partners', 'order_nr');
	}
}