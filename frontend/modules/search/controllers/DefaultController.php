<?php

class DefaultController extends FrontendController
{
    protected $_defaultKeyword = 'Поиск';
    protected $_defaultDescription = 'Поиск';
    protected $_defaultTitle = 'Поиск';
    
    public function actionIndex() {
        
        if(isset($_POST['query'])) {
            $query = $_POST['query'];
        } else {
            $query = '';
        }
        
        $this->render('index', array('query' => $query));
    }
}
