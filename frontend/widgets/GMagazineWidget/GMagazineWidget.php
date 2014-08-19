<?php
/**
* widget for showing latest magazine
*/
class GMagazineWidget extends CWidget
{
    private $_data;
    
    public function init()
    {
        $dateInfo = CTimestamp::getDate(time());
        $month = $dateInfo['mon'];
        $day = $dateInfo['mday'];
        $year = $dateInfo['year'];
        $this->_data = Yii::app()->db->createCommand('SELECT m.`magazine_id`, m.`publication_year`, m.`publication_month`, m.title, m.filename AS magazine, p.`filename` 
                                                            FROM magazine AS m 
                                                            LEFT JOIN gallery AS g ON m.`gallery_id` = g.`gallery_id`
                                                            LEFT JOIN photo AS p ON p.`gallery_id` = g.`gallery_id`
                                                        WHERE m.`is_shown` = 1 AND m.`publication_year` <= :year AND m.`publication_month` <= :month
                                                        ORDER BY m.publication_year DESC, m.publication_month DESC
                                                        LIMIT 1')->queryRow(true, array(':month'=> $month, ':year'=> $year));
        // этот метод будет вызван внутри CBaseController::beginWidget()
        parent::init();
    }
 
    public function run()
    {
        if($this->_data !== false)
            $this->render('index', array('data' => $this->_data));
    }
}
?>
