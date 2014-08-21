<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'Гороскоп, Atmosphera';
    public $meta_description='Гороскоп | Atmosphera';
    public $meta_title='Гороскоп | Atmosphera';

    public function actionIndex()
	{
        Yii::import('application.widgets.GHoroscope.GHoroscopeWidget');
        $horoscope = new GHoroscopeWidget();
        $signsOrder = $horoscope->getSignsOrder();
        
        $data = Yii::app()->db->createCommand('SELECT p.`post_id`, p.`gallery_id`, h.`content`, h.`publication_date`, p.`title`, p.`created_date`, ph.`filename` 
                                                        FROM horoscope AS h 
                                                        LEFT JOIN posting AS p ON h.`post_id` = p.`post_id`
                                                        LEFT JOIN gallery AS g ON p.`gallery_id` = g.`gallery_id`
                                                        LEFT JOIN photo AS ph ON ph.`gallery_id` = g.`gallery_id`')->queryAll();
                                                    
		$this->render('index', array('signsOrder' => $signsOrder, 'data' => $data));
	}
}