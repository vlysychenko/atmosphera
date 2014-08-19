<?php 
/* @var $this DefaultController */
Yii::import('application.modules.user.models.User');

$modelClass = get_class($news);

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
            Yii::t('main',ucfirst($this->module->id))=> Yii::app()->createUrl($this->module->id), 
            Yii::t('main',ucfirst($this->action->id)),//Yii::t('main','Update')
    ),
));
?>

<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true, // display a larger alert block?
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
    ));
    
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'news-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
));

    //show errors (for all models)
    echo $form->errorSummary(array($news, $post, $gallery), null, null, array('class' => 'alert-error'));
    
    //hidden field for post_type (set by defined controller)
    echo TbHtml::activeHiddenField($post, 'post_type');
?>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($news, 'publication_date', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
                    'name'=>$modelClass.'[publication_date]',
                    'id'=>$modelClass.'_publication_date',
                    'value'=>$news->publication_date,
                    'format' => 'yyyy-MM-dd hh:mm:ss',
                    'pluginOptions' => array(
                        //'language' => Yii::app()->language,
                    ),
                ));
            ?>
        </div>
    </div>    

    <?php //echo $form->dropDownListControlGroup($news, 'user_id', CHtml::listData(User::model()->findAll(), 'user_id', 'email'), array('size'=>1)); ?>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($news,'user_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($news, 'user_id', CHtml::listData(User::model()->findAll(), 'user_id', 'email'), array('size'=>1)); ?>
            <?php //echo TbHtml::dropDownList($modelClass.'[user_id]', $news->user_id, CHtml::listData(User::model()->findAll(), 'user_id', 'email'), array('size'=>1)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($post,'title', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo TbHtml::activeTextField($post, 'title', array()); ?>
        </div>
    </div>
        
    <?php echo $form->textFieldControlGroup($post, 'description', array('span'=>8)); ?>

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($news, 'anounce', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                    'model' => $news,
                    'attribute' => 'anounce',
                    'id' => $modelClass.'_anounce',
                    'name' => $modelClass.'[anounce]',
                    'options' => array(
                        'lang' => Yii::app()->language,
                        'direction' => 'ltr',
                        'minHeight'=>100,
                        'toolbar' => true,
                        'iframe' => false,
                        ),
                    ));
            ?>
        </div>
    </div>   

<?php if ($modelClass == 'News') { ?>    
    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($news, 'content', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                    'model' => $news,
                    'attribute' => 'content',
                    'id' => $modelClass.'_content',
                    'name' => $modelClass.'[content]',
                    'options' => array(
                        'lang' => Yii::app()->language,
                        'direction' => 'ltr',
                        'minHeight'=>100,
                        'toolbar' => true,
                        'iframe' => false,
                        ),
                    ));
            ?>
        </div>
    </div>   
<?php } ?>    
    
    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($post, Yii::t('main', 'Tag List'), array(
            'for'=>'Posting_tagList',
            'class'=>'control-label',
        )); ?>
        <div class="controls">
            <?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'asDropDownList' => false,
                    'id' => 'Posting_tagList',
                    'name' => 'Posting[tagList]',
                    'value' => $post->tagList,
                    'pluginOptions' => array(
                        'tags' => Tag::allTagsList(),
                        'value' => $post->tagList,
                        'placeholder' => Yii::t('main', 'Type tags separated by comma'),
                        'width' => '40%',
                        'tokenSeparators' => array(',', ' ')
                    )));
            ?>
        </div>
    </div>   

    <div class="control-group">
        <?php echo TbHtml::activeLabelEx($news, Yii::t('main', 'Gallery'), array(
            'for'=>'Posting_gallery',
            'class'=>'control-label',
        )); ?>
        <div class="controls">
            <?php $this->widget('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget', array(
                    'fileFormClass' => 'PhotoFileForm',
                    'gallery' => $gallery,
                    'galleryType' => 1,
                    'uploadAction' => Yii::app()->createUrl('gallery/default/uploadfile'),
                    'photoCountMax' => 0,
                    'allowedExtensions' => Yii::app()->params['upload']['image']['allowedExtensions'],//array('gif', 'jpg', 'jpeg', 'png'),
                ));
            ?>
        </div>
    </div>
        
    <div class="buttons">
        <? echo TbHtml::submitButton($news->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'),array('class'=>'fl-r'))?>
    </div>
  
<?php
$this->endWidget();    
?>