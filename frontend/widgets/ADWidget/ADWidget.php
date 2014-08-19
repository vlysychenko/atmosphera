<?php
/**
* widget for showing latest magazine
*/
class ADWidget extends CWidget
{
    private $_data;
    public $countBanners;
    
    public function init()
    {
        $this->_data = Yii::app()->db->createCommand('SELECT  b.title, b.link, ph.filename, ph.mime_type FROM banners AS b
                                                            LEFT JOIN gallery AS g ON g.`gallery_id` = b.`gallery_id`
                                                            LEFT JOIN photo AS ph ON ph.`gallery_id` = g.`gallery_id`
                                                            WHERE b.is_active = 1
                                                            ORDER BY RAND()
                                                            LIMIT '.$this->countBanners)->queryAll();
        parent::init();
    }
 
    public function run()
    {        
        $this->render('index', array('data' => $this->_data));
    }
}
?>
