<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'gallery-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'focus'=>array($model, 'title'),
));

        $this->widget('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget', array(
            'gallery' => $model,
            'galleryType' => 1,
            'uploadAction' => Yii::app()->createUrl('gallery/default/uploadfile'),
            'photoCountMax' => 0,
        ));
        
        echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array(
            'name'=>'Gallery[save]',
            'class'=>'fl-r'
        ));

$this->endWidget();  
?>
