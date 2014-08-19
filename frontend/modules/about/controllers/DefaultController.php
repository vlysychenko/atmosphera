<?php

class DefaultController extends FrontendController
{
    public $meta_keywords= 'О нас, Granat';
    public $meta_description='О нас | Granat';
    public $meta_title='О нас | Granat';
	public function actionIndex()
	{
		$this->render('index');
	}
}