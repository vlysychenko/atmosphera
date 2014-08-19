<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		//$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
        $url = Yii::app()->createAbsoluteUrl('user/login');
        $this->redirect($url);
	}

}