<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'Дизайн интерьера, Atmosphera';
    public $meta_description='Дизайн интерьера | Atmosphera';
    public $meta_title='Дизайн интерьера | Atmosphera';

	public function actionIndex()
	{
        //data for slider widget
        $sliderData = Yii::app()->db->createCommand('SELECT p.`title` AS p_title, p.post_id AS id, n.`publication_date`, u.`firstname`, u.`lastname`, g.`gallery_id` FROM design AS n
                                                            LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                                                            LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                                                            LEFT JOIN gallery AS g ON g.`gallery_id` = p.`gallery_id`
                                                        WHERE n.`is_slider` >= 1 AND n.`publication_date` <= NOW() AND p.is_active = 1
                                                        ORDER BY n.`is_slider` ASC')->queryAll();
                                                        
        $sqlComand = Yii::app()->db->createCommand('SELECT n.post_id, p.`title` AS p_title, n.`publication_date`, u.`firstname`, u.`lastname`, n.anounce, n.content FROM design AS n
                                                        LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                                                        LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                                                        WHERE p.is_active = 1 AND n.`publication_date` <= NOW()
                                                        ORDER BY n.`publication_date` DESC');

        $count=Yii::app()->db->createCommand('SELECT count(n.post_id) FROM design AS n
                                                        LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                                                        LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                                                        WHERE p.is_active = 1 AND n.`publication_date` <= NOW()
                                                        ORDER BY n.`publication_date` DESC')->queryScalar();
        $dataProvider=new CSqlDataProvider($sqlComand, array(
            'totalItemCount'=>$count,
            'keyField' => 'post_id',
            'pagination'=>array(
                'pageSize'=>6,
            ),
        ));
        $this->render('index',array('dataProvider'=>$dataProvider, 'sliderData' => $sliderData));
	}

    public function actionView(){
        $categoryId = Yii::app()->request->getParam('id');
        $data = Yii::app()->db->createCommand("SELECT n.anounce, n.content, n.publication_date, u.firstname, u.lastname, p.title, p.description,p.created_date, p.gallery_id, g.is_active, ph.filename, ph.thumb_filename, p.description, p.title
                                                FROM design AS n
                                                    LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                                                    LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                                                    LEFT JOIN gallery AS g ON g.`gallery_id` = p.`gallery_id`
                                                    LEFT JOIN photo AS ph ON g.`gallery_id` = ph.`gallery_id`
                                                WHERE p.is_active = 1 AND n.`publication_date` <= NOW() AND n.category = ".$categoryId)->queryAll();
//        if($data !== false) {
//            if (isset($data['gallery_id'])) {
//                $gallery_id = $data['gallery_id'];
//                $photos = Yii::app()->db->createCommand("SELECT f.filename, f.description
//                                                         FROM photo AS f
//                                                         WHERE f.gallery_id = :gallery_id
//                                                         ORDER BY f.sort_order"
//                                                       )->queryAll(true, array(':gallery_id'=>$gallery_id));
//            }
//            $model = Design::model()->findByPk($postId);
            $this->render('design',array('allData'=>$data));
//        } else
//            $this->redirect(Yii::app()->createAbsoluteUrl('/site/default/error'));
    }
    
    /**
    * Action for downloading.
    * Create link that points to this action.
    * 
    * @param mixed $filename
    */
    public function actionDownloadFile($filename){
        $path = Yii::app()->params['uploadDir'];
        if(file_exists($path.$filename))
        {
            return Yii::app()->getRequest()->sendFile($filename, @file_get_contents($path.$filename));
        }
    }
}