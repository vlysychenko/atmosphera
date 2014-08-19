<?php

class DefaultController extends BackendController
{
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
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actionIndex()
	{
        $model = new Magazine('search');
        if(isset($_GET['Magazine'])){
            $model->attributes = $_GET['Magazine'];
        }
		$this->render('index', array('model' => $model));
	}
    
    public function actionCreate(){
        $model = new Magazine();
        $gallery = new Gallery();
        if(isset($_POST['Magazine'])){
            $model->attributes = $_POST['Magazine'];
            if(isset($_POST['magazine-file'])) $model->filename = $_POST['magazine-file'];
            Yii::import('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget');
            $galleryWidget = New PhotoGalleryWidget;
            $galleries = $galleryWidget->validateGallery($_POST);
            
            if($model->saveMagazine($galleries)){
                $strMessage = Yii::t('main','Magazine was created successfully');
                Yii::app()->user->setFlash('success', $strMessage);    //show flash message
                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('/magazine/default/index'));
            }else{
                $gallery = $galleries[0];  //returns gallery with errors to form
            }
        }            
        $this->render('create', array('model' => $model, 'gallery' => $gallery));
    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = Magazine::model()->with(array('gallery' => array('with' => 'photos')))->findByPk($id);
        $gallery = $model->gallery;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Magazine']))
        {
            $model->attributes = $_POST['Magazine'];
            if(isset($_POST['magazine-file'])) $model->filename = $_POST['magazine-file'];
            Yii::import('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget');
            $galleryWidget = New PhotoGalleryWidget;
            $galleries = $galleryWidget->validateGallery($_POST);
            
            if($model->saveMagazine($galleries)){
                $strMessage = Yii::t('main','Magazine was saved successfully');
                Yii::app()->user->setFlash('success', $strMessage);    //show flash message
                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('/magazine/default/index'));
            }else{
                $gallery = $galleries[0];  //returns gallery with errors to form
            }
        }
        if(empty($gallery)) $gallery = new Gallery();
        $this->render('create',array(
            'model'=>$model,'gallery' => $gallery
        ));
    }
    
    public function actionActivate(){
        $id = Yii::app()->request->getParam('id');
        $onoff = Yii::app()->request->getParam('on');
        Magazine::activation($id, $onoff);
        Yii::app()->end();        
    }
    
    public function actionUpload(){
        $model = new FileForm();
        $model->file = CUploadedFile::getInstance($model, 'file');
        
        if (is_object($model->file)) {
            $fileName =  uniqid() . '_' . $model->file->name;         //define main file name
            $success = $model->file->saveAs(Yii::app()->params['uploadDir'] . $fileName);            
            echo CJSON::encode(array(
                            'success'=>$success, 
                            'filename'=>$fileName, //$newname,
//                            'itemHtml'=>'<div>ssssssssssss</div>',
                        ));
        } else {
//            unlink($file->tempName);
            return false; 
        }
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = Magazine::model()->with(array('gallery' => array('with' => 'photos')))->findByPk($id);
        $model->deleteMagazine();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    } 
}