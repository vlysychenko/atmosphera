<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'Партнеры, Atmosphera';
    public $meta_description='Партнеры | Atmosphera';
    public $meta_title='Партнеры | Atmosphera';

    public function actionIndex()
	{
        $sqlComand = Yii::app()->db->createCommand(sprintf ('SELECT p.partner_id, p.title, p.description, p.contacts, p.gallery_id 
                                                    FROM partners p
                                                    LEFT JOIN gallery g ON g.`gallery_id` = p.`gallery_id`
                                                    WHERE p.is_active = 1 AND p.partner_id <> %d
                                                    ORDER BY p.order_nr ASC',  Yii::app()->params['partner_id']));
        $count=Yii::app()->db->createCommand(sprintf('SELECT count(p.partner_id) 
                                              FROM partners p
                                              LEFT JOIN gallery AS g ON g.`gallery_id` = p.`gallery_id`
                                              WHERE p.is_active = 1 AND p.partner_id <> %d',  Yii::app()->params['partner_id']))->queryScalar();
        $dataProvider=new CSqlDataProvider($sqlComand, array(
            'totalItemCount'=>$count,
            'keyField' => 'partner_id',
            'pagination'=>array(
                'pageSize'=>5,
            ),
        ));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

    public function getIndexFotoFile($gallery_id){
        return $filename = Yii::app()->db->createCommand('SELECT filename FROM photo WHERE gallery_id = :id AND is_top = 1')->queryScalar(array(':id' => $gallery_id));
    }
}