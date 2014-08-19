<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'Галерея, Granat';
    public $meta_description='Галерея | Granat';
    public $meta_title='Галерея | Granat';

    public function actionIndex()
	{
        $sqlComand = Yii::app()->db->createCommand('SELECT n.post_id, p.title AS p_title, n.publication_date, u.firstname, u.lastname, n.anounce,
                                                    (SELECT filename FROM photo WHERE gallery_id = p.gallery_id AND is_top = 1 LIMIT 1) filename
                                                        FROM galleryposts AS n
                                                        LEFT JOIN users AS u ON u.user_id = n.user_id
                                                        LEFT JOIN posting AS p ON p.post_id = n.post_id
                                                        WHERE p.is_active > 0 AND n.publication_date <= NOW()
                                                        ORDER BY n.publication_date DESC');
        $count=Yii::app()->db->createCommand('SELECT count(n.post_id) FROM galleryposts AS n LEFT JOIN posting AS p ON p.post_id = n.post_id 
                                                        WHERE p.is_active > 0 AND n.publication_date <= NOW()')->queryScalar();
        $dataProvider=new CSqlDataProvider($sqlComand, array(
            'totalItemCount'=>$count,
            'keyField' => 'post_id',
            'pagination'=>array(
                'pageSize'=>6,
            ),
        ));

		$this->render('index',array('dataProvider'=>$dataProvider));
	}
    
    public function actionView() {
        $postId = Yii::app()->request->getParam('id');
        $gallery = Yii::app()->db->createCommand("SELECT n.anounce, n.publication_date, p.title, p.description, p.gallery_id 
                                                  FROM galleryposts AS n
                                                        LEFT JOIN posting AS p ON p.post_id = n.post_id
                                                  WHERE p.is_active = 1 AND p.post_id = :post_id AND n.publication_date <= NOW()"
                                                )->queryRow(true, array(':post_id'=>$postId));
        if (isset($gallery)) {
            $gallery_id = $gallery['gallery_id'];
        }
        $photos = Yii::app()->db->createCommand("SELECT f.filename, f.description 
                                                 FROM photo AS f
                                                 WHERE f.gallery_id = :gallery_id
                                                 ORDER BY f.sort_order"
                                               )->queryAll(true, array(':gallery_id'=>$gallery_id));
        if($gallery !== false) {
            $model = GalleryPosts::model()->findByPk($postId);
            $this->render('view',array('gallery'=>$gallery, 'photos'=>$photos, 'model'=>$model));
        } else {
            $this->redirect(Yii::app()->createAbsoluteUrl('/site/default/error'));
        }
    }
    
}