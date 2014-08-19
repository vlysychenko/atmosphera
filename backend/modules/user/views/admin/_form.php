<?$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(Yii::t('main','User')=> Yii::app()->createUrl('user/admin'), Yii::t('main','Create User')),
//'homeLink' => '',
));?>

<?php 
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
//    $form = $this->beginWidget('ActiveForm', array(
        'id'=>'user-form',
//        'layout' => 'horizontal',
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'focus'=>array($model, 'email'),
));
?>
    <div class="control-group">
        <?php echo Yii::t('main','Fields with <span class="required">*</span> are required.'); ?>
    </div>
	<?php echo CHtml::errorSummary(array($model)); ?>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model,'email', array('class'=>'fl-l w-200 mr-20'));?>
        <div class="controls">
            <?  echo TbHtml::activeTextField($model,'email', array('size'=>60,'maxlength'=>128, 'style'=>'width:400px'));?>
        </div>
    </div>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model,'lastname', array('class'=>'fl-l w-200'));?>
        <div class="controls">
             <?echo TbHtml::activeTextField($model,'lastname', array('size'=>60,'maxlength'=>128, 'style'=>'width:400px'));?>
        </div>
    </div>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model,'firstname', array('class'=>'fl-l mr-20 w-200'));?>
        <div class="controls">
            <?echo TbHtml::activeTextField($model,'firstname', array('size'=>60,'maxlength'=>128, 'style'=>'width:400px'));?>
        </div>
    </div>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model,'newPassword', array('class'=>'fl-l w-200'));?>
        <div class="controls">
            <?echo TbHtml::activeTextField($model,'newPassword', array('size'=>60,'maxlength'=>128, 'style'=>'width:400px'));?>
	    </div>
    </div>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model,'verifyPassword', array('class'=>'fl-l w-200'));?>
        <div class="controls">
            <?echo TbHtml::activeTextField($model,'verifyPassword', array('size'=>60,'maxlength'=>128, 'style'=>'width:400px'));?>
        </div>
    </div>
    
    <div class="buttons">
        <? echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
    </div>

<?php $this->endWidget(); ?>

