<?php
/* @var $this HoroscopeController */
/* @var $model Horoscope */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'horoscope-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary(array($model, $gallery)); ?>
    
    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model, 'publication_date', array(
            'class'=>'control-label'
        )); ?>
        <div class="controls">
            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                    'name'=>'Horoscope[publication_date]',
                    'value'=>$model->publication_date,
                    'pluginOptions' => array(
                        'format' => 'yyyy-mm-dd',
                        'value' => $model->publication_date,
                    ),
                    'htmlOptions' => array(
                        'id'=>'Horoscope_publication_date',
                    ),
                ));
            ?>
            <span class="add-on">
                <span class="icon-calendar"></span>
            </span>
            <?php echo $form->error($model, 'publication_date'); ?>
        </div>
    </div>  
    
    <?php echo $form->textFieldControlGroup($model->post, 'title', array('size'=>11,'maxlength'=>11,'disabled'=>'disabled')); ?>
    
    <? echo $form->hiddenField($model, 'post_id')?>

    
    <div class="control-group" style="margin-right: 55px;">
        <?php echo TbHtml::activeLabelEx($model, 'content', array(
            'class'=>'control-label'
        )); ?>
        <div class="controls">
            <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                    'model' => $model,
                    'attribute' => 'content',
                    'id' => 'Horoscope_content',
                    'name' => 'Horoscope[content]',
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
    
    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model, Yii::t('main', 'Gallery'), array(
            'for'=>'Posting_gallery',
            'class'=>'control-label',
        )); ?>
        <div class="controls">
            <?
            $this->widget('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget', array(
                'gallery' => $gallery,
                'galleryType' => 1,
                'uploadAction' => Yii::app()->createUrl('gallery/default/uploadMagazine'),
                'photoCountMax' => 1,
                'checkBoxClass' => 'hide',
                'radiobuttonClass' => 'hide',
            ));
            ?>
        </div>
    </div>
        
    <div class="buttons">
        <? echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->