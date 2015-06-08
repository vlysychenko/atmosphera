<?php
/**
 *
 * SiteController class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class SiteController extends FrontendController
{
    public $meta_keywords= 'Главная, Atmosphera';
    public $meta_description='Главная | Atmosphera';
    public $meta_title='Главная | Atmosphera';

    public function actionIndex()
	{
		$this->render('index',array('newsData'=> $this->prepareNewsData(),
                                    'slides' =>  $this->prepareSlides(),
                                    'image'=> $this->prepareImage(),
                                    ));
	}
    
    protected function prepareNewsData () {
        $newsData = Yii::app()->db->createCommand('SELECT n.post_id, p.`title`  p_title, n.`publication_date`, u.`firstname`, u.`lastname`, n.anounce, n.content, g.gallery_id
                                                            FROM news n
                                                            LEFT JOIN users u ON u.`user_id` = n.`user_id`
                                                            LEFT JOIN posting p ON p.`post_id` = n.`post_id`
                                                            LEFT JOIN gallery g ON g.`gallery_id` = p.`gallery_id`
                                                            WHERE n.is_top >= 1  AND n.publication_date <= NOW() AND p.is_active = 1
                                                            ORDER BY n.`publication_date` DESC')->queryAll();
        foreach($newsData as &$news){
            $news['photo'] = Yii::app()->db->createCommand('SELECT filename, description FROM photo WHERE gallery_id = :gallery_id AND is_top = 1')->queryRow(true, array('gallery_id' => $news['gallery_id']));            
        }
        return $newsData;
        
    }
    
    protected function prepareSlides () {
        $slides = array();
        $data = Yii::app()->db->createCommand('SELECT gp.*, p.title post_title, ph.filename, ph.title photo_title, ph.description photo_description, u.firstname, u.lastname
                                                            FROM galleryposts gp
                                                            LEFT JOIN users u ON u.user_id = gp.user_id                                                            
                                                            LEFT JOIN posting p ON p.post_id = gp.post_id
                                                            LEFT JOIN gallery g ON g.`gallery_id` = p.gallery_id
                                                            LEFT JOIN photo ph ON ph.gallery_id = g.gallery_id
                                                            WHERE gp.is_top = 1 AND gp.publication_date <= NOW()
                                                            ORDER BY ph.sort_order DESC')->queryAll();
        foreach ($data as $slide) {
            $slides[] = array(
                'url' => ImageHelper::imageUrl('main_page_slider', $slide['filename']),
                'content' => sprintf('<a href=\'%s\'><img src=\'%s\' alt=\'%s\' title=\'%s\'></img></a>' , 
                                Yii::app()->createAbsoluteUrl('portfolio/default/view', array('id' => $slide['post_id'])), 
                                ImageHelper::imageUrl('main_page_slider', $slide['filename']), 
                                ContentHelper::prepareStr($slide['photo_description']), 
                                ContentHelper::prepareStr($slide['photo_description'])
                                ),
            );  
        }
        return $slides;  
    }    

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    public function prepareImage(){
        $path = Otherproperties::model()->findByPk('mainpage');
        if(!$path->value){
            $image = '';
        } else {
            $image = Yii::app()->params['uploadUrl'].$path->value;
        }
        return $image;
    }
}