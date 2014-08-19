<?php

class AdminController extends BackendController
{
	public $defaultAction = 'admin';
    public $title = '';
    public $strMessage;
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $on = Yii::app()->request->getParam('on');
        $id = Yii::app()->request->getParam('id');
        if(Yii::app()->request->isAjaxRequest && isset($on) && isset($id)) {
            $fields = array('status');
            $model = $this->loadUserModel(); 
            $model->status = ($on ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
            /*if($model->status == User::STATUS_ACTIVE) {
                $passGen = new PassGen();   
                $model->newPassword = $passGen->generate($iLength = 6);
                $model->password = Yii::app()->getModule('user')->encrypting($model->newPassword);
                $model->activkey = Yii::app()->getModule('user')->encrypting(microtime().$model->password);
                $fields = array_merge($fields, array('password','activkey'));
            }*/
            $model->save(true, $fields);
            Yii::app()->end();  
        }
        $this->layout = 'application.views.layouts.main';
//		$dataProvider=new CActiveDataProvider('User', array(
//			'pagination'=>array(
//				'pageSize'=>Yii::app()->controller->module->user_page_size,
//			),
//		));
        $model = new User('search');
        if(isset($_GET['User'])){
            $model->attributes = $_GET['User'];
        }

		$this->render('index',array(
			'model'=>$model,
		));
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->title = Yii::t('main', 'Create User');
        $this->strMessage = Yii::t('main','User was created successfully');
        $this->editUser();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate() {
        $this->title = Yii::t('main', 'Update User');
        $this->strMessage = Yii::t('main','User was saved successfully');
        $this->editUser();
    }
    
    private function editUser() {
        $this->layout = 'application.views.layouts.main';
        $id = Yii::app()->request->getParam('id');  //check input param
        $model = (isset($id) ? User::model()->findByPk($id) : New User);
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			if($model->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->newPassword);
				$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				if ($model->save()) {
                    Yii::app()->user->setFlash('success', $this->strMessage);
                    $this->redirect(array('/user/admin'));
                }
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)	{
//			 we only allow deletion via POST request
			$model = $this->loadUserModel();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!Yii::app()->request->isAjaxRequest)
				$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	protected function loadUserModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
}