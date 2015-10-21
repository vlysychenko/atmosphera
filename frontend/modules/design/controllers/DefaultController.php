<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'Дизайн, Atmosphera';
    public $meta_description='Дизайн | Atmosphera';
    public $meta_title='Дизайн | Atmosphera';

    public function actionIndex()
    {
        $categoryId = Yii::app()->request->getParam('post_id');
        //data for slider widget
        $sql = 'SELECT p.`title` AS p_title, p.post_id AS id, n.`publication_date`, u.`firstname`, u.`lastname`, g.`gallery_id`,
                (SELECT photo.`filename` FROM photo WHERE photo.`gallery_id` = g.`gallery_id` AND photo.`is_top` = 1) AS `filename`
            FROM design AS n
                LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                LEFT JOIN gallery AS g ON g.`gallery_id` = p.`gallery_id`
            WHERE n.`is_slider` >= 1 AND n.`publication_date` <= NOW() AND p.is_active = 1
            ORDER BY n.`is_slider` ASC';
        $sliderData = Yii::app()->db->createCommand($sql)->queryAll();
        if(isset($categoryId)){
            $title = Yii::app()->db->createCommand("SELECT category FROM category WHERE id= ".$categoryId)->queryRow();
            $this->meta_title = $title['category'].' | Atmosphera';

            $sqlComand = Yii::app()->db->createCommand('SELECT n.post_id, p.`title` AS p_title, n.`publication_date`, u.`firstname`, u.`lastname`, n.anounce, n.content, ph.filename FROM design AS n
                LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                LEFT JOIN photo AS ph ON ph.`gallery_id` = p.`gallery_id`
                WHERE p.is_active = 1 AND n.`publication_date` <= NOW() AND n.`category` ='.$categoryId.'
            ORDER BY n.is_top DESC, n.`publication_date` DESC');
        } else {
            $sqlComand = Yii::app()->db->createCommand('SELECT n.post_id, p.`title` AS p_title, n.`publication_date`, u.`firstname`, u.`lastname`, n.anounce, n.content, ph.filename FROM design AS n
                LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                LEFT JOIN photo AS ph ON ph.`gallery_id` = p.`gallery_id`
                WHERE p.is_active = 1 AND n.`publication_date` <= NOW()
            ORDER BY n.is_top DESC, n.`publication_date` DESC');

        }

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
        $postId = Yii::app()->request->getParam('id');
        $data = Yii::app()->db->createCommand("SELECT n.anounce, n.content, n.publication_date, u.firstname, u.lastname, p.title, p.description,p.created_date, p.gallery_id, g.is_active 
            FROM design AS n
            LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
            LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
            LEFT JOIN gallery AS g ON g.`gallery_id` = p.`gallery_id`
            WHERE p.is_active = 1 AND n.`publication_date` <= NOW() AND p.post_id = ".$postId)->queryRow();
        if($data !== false) {
            if (isset($data['gallery_id'])) {
                $gallery_id = $data['gallery_id'];
                $photos = Yii::app()->db->createCommand("SELECT f.filename, f.description 
                    FROM photo AS f
                    WHERE f.gallery_id = :gallery_id
                    ORDER BY f.sort_order"
                )->queryAll(true, array(':gallery_id'=>$gallery_id));
            }
            $model = Design::model()->findByPk($postId);
            $this->render('design',array('data'=>$data, 'photos'=>$photos, 'model'=>$model));
        } else
            $this->redirect(Yii::app()->createAbsoluteUrl('/site/default/error'));
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