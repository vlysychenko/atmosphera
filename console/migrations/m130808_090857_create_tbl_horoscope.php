<?php

class m130808_090857_create_tbl_horoscope extends CDbMigration
{
    public $imgHoroscope = array('Овен','Телец','Близнецы','Рак','Лев','Дева','Весы','Скорпион','Стрелец','Козерог','Водолей','Рыбы');
	public function safeUp()
	{
        $this->createTable('horoscope', array(
                'post_id' => 'INT(11) UNSIGNED NOT NULL',
                'content' => 'TEXT',
                'publication_date' => 'DATETIME',
                'PRIMARY KEY (post_id)',
            ),
             'ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );
        $this->addForeignKey('FK_horoscope_posting', 'horoscope', 'post_id', 'posting', 'post_id');
        
        
        foreach($this->imgHoroscope as $key => $sign){
            
            $this->insert('gallery', array('title' => 'Изображение для гороскопа - '.$sign));
            $galleryId = Yii::app()->db->lastInsertID;
            
            $this->insert('posting', array(
                'title' => $sign,
                'post_type' => Posting::POST_TYPE_HOROSCOPE,
                'created_date' => new CDbExpression('NOW()'),
                'is_active' => 1,
                'gallery_id' => $galleryId,
            ));
            $postId = Yii::app()->db->lastInsertID;
            
            $this->insert('horoscope', array('post_id' => $postId, 'content' => $sign));
        }
	}

	public function safeDown()
	{
        $this->dropTable('horoscope');        
	}
}
