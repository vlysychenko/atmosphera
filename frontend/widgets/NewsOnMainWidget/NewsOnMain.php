<?php

class NewsOnMain extends CWidget
{
    private $newsMain;
    private $photoNewsMain;

    public function init()
    {
        $prop = Otherproperties::model()->findByPk('news_for_main_page');
        $idnews = $prop->value;

        $news = News::model()->findByPk($idnews);

        $galleryId = Posting::model()->findByPk($idnews)->gallery_id;

        $this->photoNewsMain = Photo::model()->findByAttributes(array('gallery_id'=>$galleryId))->thumb_filename;

        $this->newsMain = $news;

    }

    public function run()
    {
        $this->render('index', array('newsMain' => $this->newsMain, 'photoNewsMain'=>$this->photoNewsMain));
    }
}