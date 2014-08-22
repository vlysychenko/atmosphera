<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'Контакты, Atmosphera';
    public $meta_description='Контакты | Atmosphera';
    public $meta_title='Контакты | Atmosphera';

    public function actionIndex()
	{
        $data = Yii::app()->db->createCommand('SELECT p.partner_id, p.title, p.description, p.contacts, p.gallery_id FROM partners AS p
                                                    LEFT JOIN gallery AS g ON g.`gallery_id` = p.`gallery_id`
                                                    WHERE p.is_active = 1 AND p.partner_id='.Yii::app()->params['partner_id'])->queryRow();
		$this->render('index',array('data'=>$data));
	}
}