    <?$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(Yii::t('main','Contacts')=> Yii::app()->createUrl('contacts'),''),
//'homeLink' => '',
));?>
<div class="form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'config-form-contacts-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>false,
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    )); ?>
    <?php if(Yii::app()->user->hasFlash('config')):?>
        <div class="alert-error">
            <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('config')); ?>
        </div>
    <?php endif; ?>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($partnerModel); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model,Yii::t('main','Link for VK'),array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'vk',array('style'=>'width: 700px')); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model,Yii::t('main','Link for Twitter'),array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'twitter',array('style'=>'width: 700px')); ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model,Yii::t('main','Link for Facebook'),array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'facebook',array('style'=>'width: 700px')); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model,Yii::t('main','Link for Odnoklassniki'),array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'odnokl',array('style'=>'width: 700px')); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($partnerModel,Yii::t('main','title'),array('class'=>'control-label')); ?>
        <div class="controls">
        <?php echo $form->textField($partnerModel,'title',array('style'=>'width: 500px')); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($partnerModel,Yii::t('main','description'),array('class'=>'control-label')); ?>
        <div class="controls">
            <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                'model' => $partnerModel,
                'attribute' => 'description',
                'id' =>'partners_description',
                'name' => 'Partners[description]',
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
    <div class="control-group">
        <?php echo $form->labelEx($partnerModel,Yii::t('main','contacts'),array('class'=>'control-label')); ?>
        <div class="controls">
            <?php $this->widget('application.widgets.imperaviRedactor.ImperaviRedactorWidget',array(
                'model' => $partnerModel,
                'attribute' => 'contacts',
                'id' =>'partners_contacts',
                'name' => 'Partners[contacts]',
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
    <div class=" buttons">
        <?php echo TbHtml::submitButton(Yii::t('main', 'Save'), array('class' => 'fl-r mt-10')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->