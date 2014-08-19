<?php

class m130810_143112_create_tbl_partners extends CDbMigration
{
	public function up()
	{
        $this->createTable('partners', array(
                'partner_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'title' => 'VARCHAR(255) NOT NULL',
                'description' => 'TEXT',
                'contacts' => 'TEXT',
                'gallery_id' => 'INT(11) UNSIGNED NOT NULL',
                'is_active' => 'TINYINT(1) NOT NULL DEFAULT 1',
                'PRIMARY KEY (partner_id)',
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );
        $this->addForeignKey('FK_partners_gallery', 'partners', 'gallery_id', 'gallery', 'gallery_id');
	}

	public function down()
	{
		$this->dropTable('partners');
	}
}