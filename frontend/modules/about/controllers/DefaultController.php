<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'О нас, Atmosphera';
    public $meta_description='О нас | Atmosphera';
    public $meta_title='О нас | Atmosphera';
	public function actionIndex()
	{
		$this->render('index');
	}
}