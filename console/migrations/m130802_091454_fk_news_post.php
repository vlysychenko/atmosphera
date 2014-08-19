<?php

class m130802_091454_fk_news_post extends CDbMigration
{
	public function up()
	{
        $this->addForeignKey('FK_news_post', 'news', 'post_id', 'posting', 'post_id', 'RESTRICT', 'RESTRICT');
    }

	public function down()
	{
		echo "m130802_091454_fk_news_post does not support migration down.\n";
		return false;
	}
}