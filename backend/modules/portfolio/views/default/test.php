<?php 
/* @var $this DefaultController */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'news-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
));
?>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($portfolio, Yii::t('main', 'Portfolio'), array(
            'for'=>'Posting_portfolio',
            'class'=>'control-label',
        )); ?>
        <div class="controls">
            <?php $this->widget('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget', array(
                    'portfolio' => $portfolio,
                    'portfolioType' => 1,
                    'uploadAction' => Yii::app()->createUrl('portfolio/default/uploadfile'),
                    'photoCountMax' => 0,
                    'allowedExtensions' => array(),
                ));
            ?>
        </div>
    </div>
        
    <div class="buttons">
        <? echo TbHtml::submitButton($portfolio->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
    </div>
  
<?php
$this->endWidget();    
?>