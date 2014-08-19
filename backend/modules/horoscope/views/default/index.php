<?php
/* @var $this HoroscopeController */
/* @var $model Horoscope */

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Horoscope')=> Yii::app()->createUrl('horoscope'), 
        Yii::t('main','Index')),
));?>

<?
    echo CHtml::link('<span class="pl-10 pr-10">'.Yii::t('main','Create').'</span>', Yii::app()->controller->createUrl("create"), array(
        'id' => 'btnAdd',
        'class' => 'btn fl-r mt-10 mb-10 hide',
    ));
?>
    <div class="fl-l" style="margin-top: 10px;">
        <div id="div-loading" class=""></div>
    </div>
<div class="clearfix"></div>
<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true, // display a larger alert block?
    'fade'=>true, // use transitions?
    'closeText'=>'&times;',//'&times;', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
        'success'=>array('block'=>true, 'fade'=>true/*, 'closeText'=>'&times;'*/), // success, info, warning, error or danger
        'error'=>array('block'=>true, 'fade'=>true/*, 'closeText'=>'&times;'*/), // success, info, warning, error or danger
        'warning'=>array('block'=>true, 'fade'=>true/*, 'closeText'=>'&times;'*/), // success, info, warning, error or danger
    ),
));
?>
<?php 
$idGrid = 'horoscope-grid';
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'horoscope-grid',
    'type'=>'striped', //'condensed, bordered, hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(
            'name' => 'title',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 150px'),
//            'filterInputOptions'=>array('style'=>'width: 100px'),
            'header'=> Yii::t('main', "Zodiac's Signs"),
            'value' => '$data->post->title',
            'filter' => false,
        ),
//        array(
//            'name' => 'content',
//            'type'=>'raw',
//            'value' => '$data->content',
//        ),        
        array(
            'name'=>'publication_date',
            'type'=>'raw',
//            'htmlOptions'=>array('style'=>'width: 220px'),
//            'filterInputOptions'=>array('style'=>'width: 150px'),
            'value'=>'$data->publication_date',
            'filter' => false,
        ),
        array(
            'htmlOptions' => array(
                'nowrap'=>'nowrap', 
                'style' => 'width: 25px'
            ),
            //'class'=>'bootstrap.widgets.TbButtonColumn',
            'class'=>'common.widgets.PButtonColumn',
            //'deleteButtonImageUrl' => false,
            //'deleteButtonIcon' => false,
            //'viewButtonIcon' => TbHtml::ICON_GLASS,
            'template' => '{update}',
            'buttons' => array(
                'update'  => array(
                    'label'=>Yii::t("main", "Update"),
                    'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->post_id))',
                    'options' => array(
                        'class' => 'button edit fl-l mr-5', 
                        'rel' => 'nofollow',
                    ),
                    'htmlTemplate' => '<span><b></b></span>',
                ),
            )                                          
        ),
    )
)); ?>
