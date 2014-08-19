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
        <?php echo TbHtml::activeLabelEx($gallery, Yii::t('main', 'Gallery'), array(
            'for'=>'Posting_gallery',
            'class'=>'control-label',
        )); ?>
        <div class="controls">
            <?php $this->widget('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget', array(
                    'gallery' => $gallery,
                    'galleryType' => 1,
                    'uploadAction' => Yii::app()->createUrl('gallery/default/uploadfile'),
                    'photoCountMax' => 0,
                    'allowedExtensions' => array(),
                ));
            ?>
        </div>
    </div>
        
    <div class="buttons">
        <? echo TbHtml::submitButton($gallery->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
    </div>
  
<?php
$this->endWidget();    
?>