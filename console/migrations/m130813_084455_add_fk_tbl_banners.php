<?php

class m130813_084455_add_fk_tbl_banners extends CDbMigration
{
	public function up()
	{
        $this->addForeignKey('FK_banners_gallery', 'banners', 'gallery_id', 'gallery', 'gallery_id');
        $this->createIndex('IDX_gallery', 'banners', 'gallery_id', true);
	}

	public function down()
	{
        $this->dropForeignKey('FK_banners_gallery', 'banners');        
	}
}