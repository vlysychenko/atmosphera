<?php
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(Yii::t('main','Tag')=> Yii::app()->createUrl('tag'), Yii::t('main','Create')),
    //'homeLink' => '',
));
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'tag-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
//        'layout' => 'horizontal',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'focus'=>array($model, 'title'),
));
?>
<div class="control-group">
<?php echo Yii::t('main','Fields with <span class="required">*</span> are required.'); ?>
</div>
<?php echo $form->errorSummary(array($model)); ?>
<div class="control-group">
    <?php echo TbHtml::activeLabelEx($model,'title', array('class'=>'control-label'));?>
    <div class="controls">

        <?echo TbHtml::activeTextField($model,'title', array('style'=>'width:600px;'));?>
    </div>
</div>

<div class="buttons">
    <? echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
</div>

<?php $this->endWidget(); ?>

