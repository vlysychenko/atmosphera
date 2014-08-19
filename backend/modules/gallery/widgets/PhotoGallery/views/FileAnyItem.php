<div class="photo-item">
    <?php 
        echo CHtml::errorSummary(array($model),null,null,array('class' => 'alert-error'));       //show model errors (after saving attempt)
        
        $thumbUrl = UrlHelper::getDefaultImageUrl();
        $photoUrl = UrlHelper::getImageUrl($model->filename, 'files');
        
        $img = CHtml::image($thumbUrl, $model->title, array('class'=>'fl-l', 'width'=>123, 'height'=>67, 'style'=>'cursor: pointer !important;'));
        echo CHtml::link($img, $photoUrl, array(
            'title'=>$model->title,
            'target'=>'_blank',
        ));
    ?>
    <div class="form-inline" style="margin-bottom: 20px;"> 
        <?php
            echo CHtml::hiddenField('FileForm['.$uniqueId.'][photos]['.$idx.'][photo_id]', $model->photo_id);
            echo CHtml::hiddenField('FileForm['.$uniqueId.'][photos]['.$idx.'][title]', $model->title);
            echo CHtml::hiddenField('FileForm['.$uniqueId.'][photos]['.$idx.'][filename]', $model->filename);
            echo CHtml::hiddenField('FileForm['.$uniqueId.'][photos]['.$idx.'][thumb_filename]', $model->thumb_filename);
            echo CHtml::hiddenField('FileForm['.$uniqueId.'][photos]['.$idx.'][mime_type]', $model->mime_type);
            
            $sTitleMaxLength = 'Max length is ' . Yii::app()->params['lengthPhotoTitle'] . ' symbols';
            $sDescMaxLength = 'Max length is ' . Yii::app()->params['lengthPhotoDescription'] . ' symbols';
         
            echo TbHtml::textField  ('FileForm['.$uniqueId.'][photos]['.$idx.'][description]', $model->description, array(
                'class'=>'fl-l', 
                'span' => 6,
                'style'=>'margin-left: 10px; margin-right: 10px;',
                'placeholder'=>Yii::t('main', 'description'),
                'title' => $sDescMaxLength, 
                'alt' => $sDescMaxLength,
            ));

        ?>
        
        <button class="delete-uploaded btn ml-10 mr-10" type="button">
            <i class="icon-trash"></i>
            <span><?=Yii::t('main', 'Delete')?></span>
        </button>
        
        <br>
        <?php echo CHtml::link(TbHtml::small($photoUrl, array('style'=>'margin-left: 10px; margin-right: 10px; cursor: pointer !important;')), $photoUrl, array(
                'title'=>$model->title, 
                //'class'=>'clearfix', 
                'target'=>'_blank',
            ));
        ?>
        
    </div>
    <span class="clearfix mb-10"></span>    
</div>