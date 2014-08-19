<?php 
/* @var $this DefaultController */

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Partners')=> Yii::app()->createUrl('partners'), 
        $model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save')),
));
?>

<?
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'partners-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
//    'htmlOptions' => array(
//        'enctype' => 'multipart/form-data'
//    ),
));
    //show errors (for all models)
echo $form->errorSummary(array($model, $gallery), null, null, array('class' => 'alert-error'));
?>

    <fieldset>
    
        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model,'title', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo TbHtml::activeTextField($model, 'title', array()); ?>
            </div>
        </div>
    
        <div class="control-group" style="margin-right: 55px;">
            <?php echo TbHtml::activeLabelEx($model, 'description', array(
                'class'=>'control-label'
            )); ?>
            <div class="controls">
                <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                        'model' => $model,
                        'attribute' => 'description',
                        'id' => 'Partners_description',
                        'name' => 'Partners[description]',
                        'options' => array(
                            'lang' => 'ru',
                            'direction' => 'ltr',
                            'minHeight'=>100,
                            'toolbar' => true,
                            'iframe' => false,
                            ),
                        ));?>
            </div>
        </div> 
    
        <div class="control-group" style="margin-right: 55px;">
            <?php echo TbHtml::activeLabelEx($model, 'contacts', array(
                'class'=>'control-label'
            )); ?>
            <div class="controls">
                <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                        'model' => $model,
                        'attribute' => 'contacts',
                        'id' => 'Partners_contacts',
                        'name' => 'Partners[contacts]',
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
                <?php $this->widget('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget', array(
                        'gallery' => $gallery,
                        'uploadAction' => Yii::app()->createUrl('gallery/default/uploadfile'),
                        'photoCountMax' => 2,
                        'allowedExtensions' => array('gif', 'jpg', 'jpeg', 'png'),
                    ));
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model,'order_nr', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo TbHtml::activeTextField($model, 'order_nr', array()); ?>
            </div>
        </div>
        
    </fieldset>
  
        <div class="buttons">
            <? echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
        </div>
  
<?php
$this->endWidget();    
?>
