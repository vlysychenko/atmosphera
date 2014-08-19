<?
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Magazines')=> Yii::app()->createUrl('magazine'), 
        $model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save')
        ),
));
 ?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'magazine-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'focus'=>array($model,'filename'),
)); 

//prepeare arrays for date
$arrYear = array();
$arrMonth = array();
for($i = 2010; $i < 2030; $i++){
    $arrYear[$i] = $i;
}
for($i = 1; $i <=12; $i++){
    $arrMonth[$i] = Magazine::getMonthName($i);
}
?>

<?php echo $form->errorSummary(array($model, $gallery), null, null, array('class' => 'alert-error')); ?>

        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model,'title', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo TbHtml::activeTextField($model, 'title', array()); ?>
            </div>
        </div>
        
        <?php //echo $form->dropDownListControlGroup($model, 'publication_year', $arrYear); ?>
        
        <?php //echo $form->dropDownListControlGroup($model, 'publication_month', $arrMonth); ?> 
        
        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model,'publication_year', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'publication_year', $arrYear, array('size'=>1)); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo TbHtml::activeLabelEx($model,'publication_month', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'publication_month',$arrMonth, array('size'=>1)); ?>
            </div>
        </div>
    
    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($model, Yii::t('main', 'Magazine'), array(
            'for'=>'Posting_gallery',
            'class'=>'control-label',
        )); ?>
        <div class="controls">
<?php
    $fileForm = new FileForm();
    $this->widget('yiiwheels.widgets.fineuploader.WhFineUploader', array(
        'id' => 'magazine-uploader',
        'name' => 'FileForm[file]',
        'model' => $fileForm,
        'uploadAction' => $this->createUrl('upload', array('fine' => 1)),
        'pluginOptions' => array(
            'multiple' => false,
            'validation'=> array(
                'allowedExtensions' => Yii::app()->params['upload']['magazine']['allowedExtensions'],
                'sizeLimit' => Yii::app()->params['upload']['magazine']['maxFileSize'], //10*1024*1024,
            ),
            'text' => array(
                'uploadButton' => '<i class="icon-plus"></i> '.Yii::t('main', 'Select Files'),
            ),
            'template' => '<div class="qq-uploader" style="margin-bottom: 20px;">
                            <div class="qq-upload-drop-area">
                                <span>{dragZoneText}</span>
                            </div>

                            <div class="qq-upload-button btn" id="btnSelectFiles" style="width: 140px;">
                                <span>{uploadButtonText}</span> 
                            </div>

                            <span class="qq-drop-processing">
                                <span>{dropProcessingText}</span>
                                <span class="qq-drop-processing-spinner"></span>
                            </span>

                            <ul class="qq-upload-list"></ul>
                        </div>',
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
        'allowedExtensions' => Yii::app()->params['upload']['image']['allowedExtensions'],

    ));
?>
        </div>
    </div>
<input id="magazine-file" type="text" style="display: none" name="magazine-file" value="<?=$model->filename?>" visible="false">

<div class="buttons">
    <? echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
</div>

<?php $this->endWidget(); ?>

<?
$str = <<<BLOCK
$('#magazine-uploader')
    .on('complete', function(event, id, name, response) {
        $('span.qq-upload-file').text(response.filename);
        $('#magazine-file').val(response.filename);
    });
    if("$model->filename" || "$model->filename" === 0)
        $('ul.qq-upload-list').append("<li class='qq-upload-success'><span class='qq-upload-file'>$model->filename</span></li>");
BLOCK;
    Yii::app()->clientScript->registerScript('magazine-uploader', $str, CClientScript::POS_READY);
?>