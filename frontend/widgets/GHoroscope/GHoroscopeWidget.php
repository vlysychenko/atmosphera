<?php

class GHoroscopeWidget extends CWidget
{
    private $_data;
    private $signs = array('Овен','Телец','Близнецы','Рак','Лев','Дева','Весы','Скорпион','Стрелец','Козерог','Водолей','Рыбы');
    private $signsOrder = array(
        '21.03-20.04',
        '21.04-21.05',
        '22.05-21.06',
        '22.06-23.07',
        '24.07-23.08',
        '24.08-23.09',
        '24.09-23.10',
        '24.10-22.11',
        '23.11-21.12',
        '22.12-20.01',
        '21.01-19.02',
        '20.02-20.03');
    
    public function init()
    {
        $dateInfo = CTimestamp::getDate(time());
        $month = $dateInfo['mon'];
        $day = $dateInfo['mday'];
        $yDay = $dateInfo['yday'];
        foreach($this->signsOrder as $key => $val){
            $arr = explode('-', $val);
            $start = explode('.', $arr[0]);
            $end = explode('.', $arr[1]);
            settype($start[0], 'integer');
            settype($start[1], 'integer');
            settype($end[0], 'integer');
            settype($end[1], 'integer');
            if($month >= $start[1] && $month <= $end[1]){
                if($day >= $start[0] || $day <= $end[0]){
                    $signMonth = $key;
                    break;
                }
            }
        }
        $this->_data = Yii::app()->db->createCommand('SELECT p.`post_id`, p.`gallery_id`, h.`content`, h.`publication_date`, p.`title`, p.`created_date`, ph.`filename` 
                                                        FROM horoscope AS h 
                                                        LEFT JOIN posting AS p ON h.`post_id` = p.`post_id`
                                                        LEFT JOIN gallery AS g ON p.`gallery_id` = g.`gallery_id`
                                                        LEFT JOIN photo AS ph ON ph.`gallery_id` = g.`gallery_id`
                                                    WHERE p.`title` LIKE :sign')->queryRow(true, array(':sign' => $this->signs[$signMonth]));
        // этот метод будет вызван внутри CBaseController::beginWidget()
        parent::init();
    }
 
    public function run()
    {        
        $this->render('index', array('data' => $this->_data));
    }
    
    public function getSignsOrder(){
        return $this->signsOrder;
    }
}
?>
