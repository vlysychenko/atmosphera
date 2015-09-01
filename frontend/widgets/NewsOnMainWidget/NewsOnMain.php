<?php

class NewsOnMain extends CWidget
{
    private $newsMain = null;
    private $photoNewsMain = null;

    public function init()
    {
        if ($prop = Otherproperties::model()->findByPk('news_for_main_page')) {
            $idnews = $prop->value;
            $news = News::model()->findByPk($idnews);
            if ($gallery = Posting::model()->findByPk($idnews)) {
                $galleryId = $gallery->gallery_id;
                $this->photoNewsMain = Photo::model()->findByAttributes(array('gallery_id'=>$galleryId))->thumb_filename;
                $this->newsMain = $news;
            }
        }
    }

    public function run()
    {
        $this->render('index', array('newsMain' => $this->newsMain, 'photoNewsMain'=>$this->photoNewsMain));
    }
}