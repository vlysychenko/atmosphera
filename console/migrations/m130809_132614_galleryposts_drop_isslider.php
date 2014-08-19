<?php

class m130809_132614_galleryposts_drop_isslider extends CDbMigration
{
	public function up()
	{
        $this->dropColumn('galleryposts', 'is_slider');
	}

	public function down()
	{
		echo "m130809_132614_galleryposts_drop_isslider does not support migration down.\n";
		return false;
	}

}