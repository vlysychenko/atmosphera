<?php
/* @var $this DefaultController */

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','About Us')=> Yii::app()->createUrl('about'), 
        Yii::t('main','Index')),
));
?>

<?php if(Yii::app()->user->hasFlash('index')):?>
<div class="info">
    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('index')); ?>
</div>
<?php endif; ?>
    
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'about-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?php echo $form->errorSummary(array($model)); ?>
    
    <div class="control-group" style="margin-right: 55px;">
        <?php echo TbHtml::activeLabelEx($model, 'content', array(
            'class'=>'control-label'
        )); ?>
        <div class="controls">
            <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                    'model' => $model,
                    'attribute' => 'content',
                    'id' => 'About_content',
                    'name' => 'About[content]',
                    'options' => array(
                        'lang' => 'ru',
                        'direction' => 'ltr',
                        'minHeight'=>100,
                        'toolbar' => true,
                        'iframe' => false,
                        ),
                    ));
            ?>
        </div>
    </div> 
    
    <div class="buttons">
        <? echo TbHtml::submitButton(Yii::t('main','Save'),array('class'=>'fl-r'))?>
    </div>

<?php $this->endWidget(); ?>