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
class SiteController extends EController
{
    public function filters()  {
        return CMap::mergeArray(parent::filters(),array(
            'accessControl',
        ));
    }

    public function accessRules() {
        return array(
            // not logged in users should be able to login and view captcha images as well as errors
            array('allow', 'actions' => array('index', /*'captcha', */'login', 'error')),
            // logged in users can do whatever they want to
            array('allow', 'users' => array('@')),
            // not logged in users can't do anything except above
            array('deny'),
        );
    }

	public function actionIndex()
	{
        $this->layout = 'application.views.layouts.main';
        Yii::app()->user->isGuest ?  $this->redirect(Yii::app()->getModule('user')->loginUrl) :
                                     $this->redirect(Yii::app()->getModule('user')->adminUrl);
	}
  
  /**
   * This is the action to handle external exceptions.
   */
  public function actionError()
  {

    if($error=Yii::app()->errorHandler->error)
    {
        $this->layout = 'error';
      if(Yii::app()->request->isAjaxRequest)
        echo $error['message'];
      else
        $this->render('error', $error);
    }
  }
}