<?php
//

class DefaultController extends BackendController
{
    public function actionTestupload() {
        $portfolio = New Portfolio;
        $this->render('test', array('portfolio' => $portfolio));
    }
    
    public function actionUploadfile() {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoPortfolioWidget;
            $portfolioWidget->uploadPhoto();
        }
    }
    public function actionUploadimage() {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoPortfolioWidget;
            $portfolioWidget->uploadPhoto();
        }
    }
    public function actionUploadMagazine() {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
            $portfolioWidget = New PhotoPortfolioWidget;
            $portfolioWidget->checkBoxClass = 'hide';
            $portfolioWidget->radiobuttonClass = 'hide';
            $portfolioWidget->uploadPhoto();
        }
    }
        
}  
?>
