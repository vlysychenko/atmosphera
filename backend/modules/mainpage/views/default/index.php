<?php
/* @var $this DefaultController */
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
        'links'=>array(
            Yii::t('main',ucfirst($this->module->id))=> Yii::app()->createUrl($this->module->id),
            Yii::t('main',ucfirst($this->action->id)),
        ),
    ));
?>

<?php
$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'design-form',
'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
'htmlOptions' => array(
'enctype' => 'multipart/form-data'
),
));
?>

<div class="control-group">
<!--    --><?php //echo TbHtml::activeLabelEx($otherproperties,'oterproperties', array('class'=>'control-label')); ?>
    <div class='control-group'><?php echo Yii::t('main', 'Select news for main page')?></div>
    <div class="controls-group">
        <?php echo CHtml::activeDropDownList($newsForMainPage, 'value',
            CHtml::listData($news, 'post_id', 'title'), array('size'=>1, 'empty'=>'', 'name'=>'newsForMainPage')); ?>
    </div>
</div>

    <div class="control-group">
        <div class='control-group'><?php echo Yii::t('main', 'Link on facebook')?></div>
        <div class="controls-group">
            <?php echo CHtml::activeTextField($linkFacebook, 'value', array('name'=>'linkFacebook'))?>
        </div>
    </div>

    <div class="control-group">
        <div class='control-group'><?php echo Yii::t('main', 'Link on vkontakt')?></div>
        <div class="controls-group">
            <?php echo CHtml::activeTextField($linkVk, 'value', array('name'=>'linkVk'))?>
        </div>
    </div>

    <div class="control-group">
        <?php echo Yii::t('main', 'Select a photo for the front page');
        echo '<div>'.CHtml::image('/upload/'.$mainpage->value, 'image', array('hight'=>150, 'width'=>100)).'</div>';
        ?>

        <div class="control-group">
            <?php $this->widget('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget', array(
                    'fileFormClass' => 'PhotoFileForm',
                    'portfolio' => $portfolio,
                    'portfolioType' => 1,
                    'uploadAction' => Yii::app()->createUrl('portfolio/default/uploadfile'),
                    'photoCountMax' => 1,
                    'allowedExtensions' => Yii::app()->params['upload']['image']['allowedExtensions'],//array('gif', 'jpg', 'jpeg', 'png'),
                ));
            ?>
        </div>
    </div>

    <div class="buttons">
        <? echo TbHtml::submitButton(Yii::t('main','Save'),array('class'=>'fl-r'))?>
    </div>

<?php
$this->endWidget();
?>