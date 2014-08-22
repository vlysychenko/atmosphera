<?php

class DefaultController extends Controller
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
        $model = new Banners('search');
        if(isset($_GET['Banners'])){
            $model->attributes = $_GET['Banners'];
        }
        $this->render('index', array('model' => $model));
    }
    
    public function actionCreate()
    {
        $model = new Banners();
        $portfolio = new Portfolio();
        $portfolio->gallery_type = 2;
        if(isset($_POST['Banners'])){
            $model->attributes = $_POST['Banners'];
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoPortfolioWidget;
            $galleries = $portfolioWidget->validatePortfolio($_POST);
            
            if($model->saveBanners($galleries)){
                $strMessage = Yii::t('main','Banners was created successfully');
                Yii::app()->user->setFlash('success', $strMessage);    //show flash message
                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('/banners/default/index'));
            }else{
                $portfolio = $galleries[0];  //returns portfolio with errors to form
            }
        }            
        $this->render('form', array('model' => $model, 'portfolio' => $portfolio));
    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = Banners::model()->with(array('portfolio' => array('with' => 'photos')))->findByPk($id);
        $portfolio = $model->portfolio;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Banners']))
        {
            $model->attributes = $_POST['Banners'];
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoGalleryWidget;
            $galleries = $portfolioWidget->validatePortfolio($_POST);
            
            if($model->saveBanners($galleries)){
                $strMessage = Yii::t('main','Banners was saved successfully');
                Yii::app()->user->setFlash('success', $strMessage);    //show flash message
                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('/banners/default/index'));
            }else{
                $portfolio = $galleries[0];  //returns portfolio with errors to form
            }
        }
        if(empty($portfolio)) $portfolio = new Portfolio();
        $this->render('form',array(
            'model'=>$model,'portfolio' => $portfolio
        ));
    }
    
    
    public function actionActivate(){
        $id = Yii::app()->request->getParam('id');
        $onoff = Yii::app()->request->getParam('on');
        Banners::activation($id, $onoff);
        Yii::app()->end();        
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = Banners::model()->with(array('portfolio' => array('with' => 'photos')))->findByPk($id);
        $model->deleteBanners();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    } 
}