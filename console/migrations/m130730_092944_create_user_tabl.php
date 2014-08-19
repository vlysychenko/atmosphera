<?php

class m130730_092944_create_user_tabl extends CDbMigration

{
    private $sqlUp = array(
        "CREATE TABLE `users` (
          user_id INT(128) UNSIGNED AUTO_INCREMENT,
          firstname VARCHAR(128) NOT NULL,
          lastname VARCHAR(128) NOT NULL,
          email VARCHAR(255) NOT NULL,
          password VARCHAR(32) NOT NULL,
          createtime INT(10) NOT NULL,
          lastvisit INT(10),
          superuser TINYINT(1),
          activkey VARCHAR(128),
          status TINYINT(1) DEFAULT 1 NOT NULL,
          PRIMARY KEY (user_id),
          UNIQUE KEY email (email)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;",

        "INSERT INTO users (user_id, firstname, lastname, email, password, activkey, createtime, lastvisit, superuser,status) VALUES
        (1, 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '9a24eff8c15a6a141ece27eb6947da0f', 1261146094, 0, 1,1),
        (2, 'demo', 'demo', 'demo@demo.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', 1261146096, 0, 0,1);
        ",
    );

    private $sqlDown = array(
        "DROP TABLE `users`",
    );

    public function safeUp()
    {
        foreach($this->sqlUp as $key=>$sql) {
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    public function safeDown()
    {
        foreach($this->sqlDown as $key=>$sql) {
            Yii::app()->db->createCommand($sql)->execute();
        }
        //echo "m130606_084942_tbl_users does not support migration down.\n";
        //return false;
    }

}