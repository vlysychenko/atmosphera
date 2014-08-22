<?php 
/* @var $this DefaultController */

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Banners')=> Yii::app()->createUrl('banners'), 
        $model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save')),
));
?>

<?
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'banners-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
//    'htmlOptions' => array(
//        'enctype' => 'multipart/form-data'
//    ),
));
    //show errors (for all models)
echo $form->errorSummary(array($model, $portfolio), null, null, array('class' => 'alert-error'));
?>

    <fieldset>
    
        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model,'title', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo TbHtml::activeTextField($model, 'title', array()); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model,'link', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo TbHtml::activeTextField($model, 'link', array()); ?>
            </div>
        </div>
    
        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model, Yii::t('main', 'Portfolio'), array(
                'for'=>'Posting_portfolio',
                'class'=>'control-label',
            )); ?>
            <div class="controls">
                <?php $this->widget('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget', array(
                        'portfolio' => $portfolio,
                        'portfolioType' => 1,
                        'uploadAction' => Yii::app()->createUrl('portfolio/default/uploadMagazine'),
                        'photoCountMax' => 1,
                        'allowedExtensions' => array(
                            'jpg','png','swf','jpeg'
                        ),
                        'checkBoxClass' => 'hide',
                        'radiobuttonClass' => 'hide',
                    ));
                ?>
            </div>
        </div>
    </fieldset>
  
        <div class="buttons">
            <? echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
        </div>
  
<?php
$this->endWidget();    
?>
