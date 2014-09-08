 <?php

class GFilterWidget extends CWidget
{
    private $_data;
     
    public function init()
    {
        $this->_data = Yii::app()->db->createCommand('SELECT * FROM category')->queryAll();
        parent::init();
    }
    
    public function run()
    {        
        $this->render('index', array('data' => $this->_data));
    }

    public function actionFilter(){
        DefaultController::actionFiltration();
    }
    
}

