<?php

class m130810_141832_update_horoscope_posting extends CDbMigration
{
	public function up()
	{
        Yii::app()->db->createCommand('update posting set post_type = 3 where post_id in (select post_id from horoscope)')->execute();
	}

	public function down()
	{
		echo "m130810_141832_update_horoscope_posting does not support migration down.\n";
		return false;
	}
}