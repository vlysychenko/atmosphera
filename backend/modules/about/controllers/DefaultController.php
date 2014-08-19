<?php

class DefaultController extends BackendController
{
    public function actionIndex()
    {
//        DebugBreak();
        $file = dirname(__FILE__).'/../../../../common/config/about-us.php';
        $content = file_get_contents($file);
        $model = new AboutForm();
        $model->content = $content;

        if(isset($_POST['AboutForm']))
        {
            $model->setAttributes($_POST['AboutForm']);
            if($model->validate()) {
                file_put_contents($file, $model->content);
                Yii::app()->user->setFlash('index', Yii::t('main', 'Your new options have been saved.'));
            }
        }
        $this->render('index',array('model'=>$model));
    }
}