<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'portfolio-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'focus'=>array($model, 'title'),
));

        $this->widget('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget', array(
            'portfolio' => $model,
            'portfolioType' => 1,
            'uploadAction' => Yii::app()->createUrl('portfolio/default/uploadfile'),
            'photoCountMax' => 0,
        ));
        
        echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array(
            'name'=>'Portfolio[save]',
            'class'=>'fl-r'
        ));

$this->endWidget();  
?>
