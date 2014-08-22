<?php

class DefaultController extends BackendController
{


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = Horoscope::model()->with(array('post' => array('with' => array('portfolio' => array('with' => 'photos')))))->findByPk($id);
        $portfolio = $model->post->portfolio;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Horoscope']))
        {
            $model->attributes=$_POST['Horoscope'];
            if(empty($_POST['Horoscope']['publication_date'])) $model->publication_date = Yii::app()->dateFormatter->format('yyyy-MM-dd hh:mm:ss', time());
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoPortfolioWidget;
            $galleries = $portfolioWidget->validatePortfolio($_POST);
            
            if($model->saveHoroscope($galleries)){
                $strMessage = Yii::t('main','Horoscope was saved successfully');
                Yii::app()->user->setFlash('success', $strMessage);    //show flash message
                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('/horoscope/default/index'));
                Yii::app()->end();
            }else{
                $portfolio = $galleries[0];  //returns portfolio with errors to form
            }
        }
        if(empty($portfolio)) $portfolio = new Portfolio();
        $this->render('update',array(
            'model'=>$model,'portfolio' => $portfolio
        ));
    }


    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model=new Horoscope('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Horoscope']))
            $model->attributes=$_GET['Horoscope'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }
}
