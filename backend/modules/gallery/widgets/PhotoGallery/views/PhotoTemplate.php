<div style="margin-bottom: 10px; margin-right: 50px;"> 
    <?php
        $sTitleMaxLength = 'Max length is ' . Yii::app()->params['lengthGalleryTitle'] . ' symbols';
        $sDescMaxLength = 'Max length is ' . Yii::app()->params['lengthGalleryDescription'] . ' symbols';

        //echo CHtml::errorSummary(array($model),null,null,array('class' => 'alert-error'));
        
        $baseName = 'FileForm['.$uniqueId.']'; 
        echo CHtml::hiddenField($baseName . '[gallery_id]', $model->gallery_id, array());
        echo CHtml::hiddenField($baseName . '[gallery_type]', $model->gallery_type, array()); 
    ?>
            
    <!--<div class="control-group">
        <?php //echo TbHtml::activeLabelEx($model, 'title', array('class'=>'fl-l w-100', 'title' => $sTitleMaxLength, 'alt' => $sTitleMaxLength));?>
        <div class="controls" style="margin-left: 100px;">
            <?php //echo TbHtml::activeTextField($model, 'title', array('name' => $baseName.'[title]', 'span' => 3, 'placeholder'=>'gallery title')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php //echo TbHtml::activeLabelEx($model, 'description', array('class'=>'fl-l w-100', 'title' => $sDescMaxLength, 'alt' => $sDescMaxLength)); ?>
        <div class="controls" style="margin-left: 100px;">
            <?php  //echo TbHtml::activeTextField($model, 'description', array('name' => $baseName . '[description]', 'span' => 8, 'placeholder'=>'gallery description')); ?>
        </div>
    </div>-->
    
    <div class="<?=$checkBoxClass?>">
        <?php echo TbHtml::activeLabelEx($model, 'is_active', array('class'=>'fl-l w-100', 'style'=>'margin-right: 10px;'));
            echo TbHtml::activeCheckBox($model, 'is_active', array(
                'name' => $baseName . '[is_active]',
                'placeholder'=>'gallery is_active',
            )); ?>
    </div>
    
</div>

<div class="qq-uploader" style="margin-bottom: 20px;">
    <div class="qq-upload-drop-area">
        <span>{dragZoneText}</span>
    </div>

    <div class="qq-upload-button btn" id="btnSelectFiles" style="width: 140px;">
        <span>{uploadButtonText}</span> 
    </div>

    <!--<div class="triggerUpload btn">
        <i class="icon-upload"></i>
        <?=Yii::t('main', 'Upload now')?>
    </div>-->

    <span class="qq-drop-processing">
        <span>{dropProcessingText}</span>
        <span class="qq-drop-processing-spinner"></span>
    </span>

    <ul class="qq-upload-list"></ul>
</div>
<!--<div class="clearfix" style="margin-bottom: 20px;"></div>-->
