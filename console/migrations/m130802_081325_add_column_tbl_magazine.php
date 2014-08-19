<?php

class m130802_081325_add_column_tbl_magazine extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('magazine', 'title', 'VARCHAR(255) NULL AFTER gallery_id' );
        $this->addColumn('magazine', 'publication_year', 'int(11) NULL AFTER gallery_id' );
        $this->addColumn('magazine', 'publication_month', 'int(11) NULL AFTER gallery_id' );
	}

	public function safeDown()
	{
        $this->dropColumn('magazine', 'title');
        $this->dropColumn('magazine', 'publication_year');
        $this->dropColumn('magazine', 'publication_month');
	}
}