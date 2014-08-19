<?php

class DefaultController extends BackendController
{
    public $partner_id ;

    public function actionIndex()
	{
        $this->partner_id = Yii::app()->params['partner_id'];
        $file = dirname(__FILE__).'/../../../../common/config/contacts.php';
        if(!is_file($file)){
            throw new CHttpException(404,'Файл контактов не найден'.$file);
        }
        $content = file_get_contents($file);
        $arr = json_decode($content, true);
        $partnerModel = Partners::model()->findByPk($this->partner_id);
        if($partnerModel == NULL){
            throw new CHttpException(404,'Указанная запись не найдена');
        }
        $model = new ContactForm();
        $model->setAttributes($arr);
        if(isset($_POST['Partners']) || isset($_POST['ContactForm'])){
            $partnerModel->attributes = $_POST['Partners'];
            $partnersuccess = $partnerModel->validate();
            if($partnersuccess) {
                $partnerModel->update();
            }
            $config = array(
                'vk'=>$_POST['ContactForm']['vk'],
                'twitter'=>$_POST['ContactForm']['twitter'],
                'facebook'=>$_POST['ContactForm']['facebook'],
                'odnokl'=>$_POST['ContactForm']['odnokl'],
            );
            $model->setAttributes($config);
            $confsuccess = $model->validate();
            if($confsuccess) {
                $str = json_encode($config);
                file_put_contents($file, $str);
            }
            if($partnersuccess && $confsuccess){
                Yii::app()->user->setFlash('config', Yii::t('main', 'Your new options have been saved.'));
            }
        }
		$this->render('index',array('model'=>$model,'partnerModel'=>$partnerModel));
	}
}