<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 204-9
 * Date: 10.08.13
 * Time: 15:30
 * To change this template use File | Settings | File Templates.
 */
class FrontendController extends Controller{

    public $meta_keywords;
    public $meta_description;
    public $meta_title;

    public function getKeywords()
    {
            $id =Yii::app()->request->getQuery('id');
            if (empty($id)){

                return $this->meta_keywords;

            }else{
                $tags = Yii::app()->db->createCommand("SELECT tag.title FROM tag LEFT JOIN tagpost ON tag.tag_id=tagpost.tag_id WHERE tagpost.post_id= ".$id)->queryAll();

                foreach($tags as $tag) {
                    $tagsList[] =  trim($tag['title']);
                }
                if(empty($tagsList)){
                    return $this->meta_keywords;
                }
                if(is_array($tagsList)){
                    natcasesort($tagsList);
                }
                return join(", ", $tagsList);
            }
    }

    public function getDescription()
    {
        if (empty($this->_post))
        {
            $id =Yii::app()->request->getQuery('id');
            if (empty($id))
            {
                return $this->meta_description;
            }else{
                $description = Yii::app()->db->createCommand("SELECT description FROM posting WHERE post_id= ".$id)->queryRow();
                return $description['description'];
            }
        }
    }

    public function getTitle()
    {
        if (empty($this->_post))
        {
            $id =Yii::app()->request->getQuery('id');
            if (empty($id))
            {
                return $this->meta_title;
            }else{
                $title = Yii::app()->db->createCommand("SELECT title FROM posting WHERE post_id= ".$id)->queryRow();
                return $title['title'];
            }
        }
    }
    
    protected function preparePartnerSlides () {
        $slides = array();
        $data = Yii::app()->db->createCommand(sprintf('SELECT  p.title, ph.filename, ph.title photo_title, ph.description photo_description
                                                            FROM partners p 
                                                            LEFT JOIN gallery g ON g.`gallery_id` = p.gallery_id
                                                            LEFT JOIN photo ph ON ph.gallery_id = g.gallery_id
                                                            WHERE p.is_active = 1 AND p.partner_id <> %d AND (ph.is_top <> 1 OR ph.is_top IS NULL)
                                                            ORDER BY ph.sort_order DESC', Yii::app()->params['partner_id']))->queryAll();
        foreach ($data as $slide) {
            $slides[] = array(
                'url' => ImageHelper::imageUrl('', $slide['filename']),
                'content' => sprintf('<img src=\'%s\' alt\'%s\' title=\'%s\'></img>' ,
                    ImageHelper::imageUrl('partner_footer_frontend', $slide['filename']),
                    ContentHelper::prepareStr($slide['title']),
                    ContentHelper::prepareStr($slide['title'])
                )
            );  
        }                                                             
        return $slides;  
    }     


    public function prepareSocialLinks(){

        $arr['facebook'] = Otherproperties::model()->findByPk('link_facebook')->value;
        $arr['vk'] = Otherproperties::model()->findByPk('link_vk')->value;

        return $arr;
    }

}