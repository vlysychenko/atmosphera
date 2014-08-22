<?php

class DefaultController extends BackendController
{
    public function actionIndex()
    {
        $model = new Partners('search');
        if(isset($_GET['Partners'])){
            $model->attributes = $_GET['Partners'];
        }
        $this->render('index', array('model' => $model));
    }
    
    public function actionCreate(){
        $model = new Partners();
        $portfolio = new Portfolio();
        $portfolio->gallery_type = 1;
        if(isset($_POST['Partners'])){
            $model->attributes = $_POST['Partners'];
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoPortfolioWidget;
            $galleries = $portfolioWidget->validatePortfolio($_POST);
            
            if($model->savePartners($galleries)){
                $strMessage = Yii::t('main','Partners was created successfully');
                Yii::app()->user->setFlash('success', $strMessage);    //show flash message
                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('/partners/default/index'));
            }else{
                $portfolio = $galleries[0];  //returns portfolio with errors to form
            }
        }
        if($model->order_nr === 0){
            $maxOrder = Yii::app()->db->createCommand('SELECT MAX(order_nr) FROM partners')->queryScalar();
            $model->order_nr = floor($maxOrder / 10) * 10 + 10;
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
        $model = Partners::model()->with(array('portfolio' => array('with' => 'photos')))->findByPk($id);
        $portfolio = $model->portfolio;
        $portfolio->gallery_type = 1;
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Partners']))
        {
            $model->attributes = $_POST['Partners'];
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoPortfolioWidget;
            $galleries = $portfolioWidget->validatePortfolio($_POST);
            
            if($model->savePartners($galleries)){
                $strMessage = Yii::t('main','Partners was saved successfully');
                Yii::app()->user->setFlash('success', $strMessage);    //show flash message
                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('/partners/default/index'));
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
        Partners::activation($id, $onoff);
        Yii::app()->end();        
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = Partners::model()->with(array('portfolio' => array('with' => 'photos')))->findByPk($id);
        $model->deletePartners();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    } 
}