<?php 
/* @var $this DefaultController */
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Magazines')=> Yii::app()->createUrl('magazine'), 
        Yii::t('main','Index')),
));

    echo CHtml::link('<span class="pl-10 pr-10">'.Yii::t('main','Create').'</span>', Yii::app()->controller->createUrl("create"), array(
        'id' => 'btnAdd',
        'class' => 'btn fl-r mt-10 mb-10',
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

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'magazine-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'template'=>"{items}\n{pager}",
    'type'=>'striped', //'condensed, bordered, hover',
    'htmlOptions' => array('class' => 'table-list'),
    //'itemsCssClass'=>'table-list',  
    'rowCssClassExpression' => '($row % 2 ? "even" : "odd")." bColor pt-5 pb-5 pl-10 pr-10 mb-5"',
    'columns'=>array(  
        array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'$data->title',
        ),
        array(
            'name'=>'publication_year',
            'type'=>'raw',
            'value'=>'$data->publication_year',
//            'filterInputOptions'=>array('style'=>'width: 110px'),
            'filter' => CHtml::listData(Magazine::model()->findAll(array('order'=>'publication_year ASC')), 'publication_year', 'publication_year')
        ),
        array(
            'name'=>'publication_month',
//            'filterInputOptions'=>array('style'=>'width: 125px'),
            'type'=>'raw',
            'value'=>'Magazine::getMonthName($data->publication_month)',
            'filter' => CHtml::listData(Magazine::model()->findAll(array('order'=>'publication_month ASC')), 'publication_month', function($obj){
                return Magazine::getMonthName($obj->publication_month);})
        ),
        
        array(
            'htmlOptions' => array(
                'nowrap'=>'nowrap',
                 'style' => 'width: 75px'
            ),
            'class'=>'common.widgets.PButtonColumn',
            'deleteButtonImageUrl' => false,
            'deleteButtonIcon' => false,
            'template' => '{update}{delete}{onoff}',
            'buttons' => array('onoff' => array(
                                            'labelExpression' => '$data->is_shown == 1 ?  Yii::t("main","Off"):Yii::t("main","On")',
                                            'url'   =>  'Yii::app()->controller->createUrl("activate", array("id" => $data->magazine_id, "on" => (!$data->is_shown) ? 1:0))',
                                            'cssClassExpression' => '$data->is_shown == 1 ? "button on fl-l mr-5" : "button off fl-l mr-5"',
                                            'options' => array(
                                                'rel' => 'nofollow',
                                                'ajax' => array(
                                                    'type' => 'get', 
                                                    'url'=>'js:$(this).attr("href")', 
                                                    'beforeSend' => 'js:function() { 
                                                                    $("#div-loading").addClass("grid-loading");
                                                                    return true;
                                                             }',
                                                    'success' => 'js:function(data) { 
                                                        $.fn.yiiGridView.update("magazine-grid");
                                                        $("#div-loading").removeClass("grid-loading");
                                                    }'
                                                ), 
                                            ),
                                            'htmlTemplate' => '<span><b></b></span>',
                                           ),

                            
                           'delete'   => array(
                                           'label'=>Yii::t("main","Delete"),
                                           'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->magazine_id))',
                                           'icon' => 'trash',
                                           'options' => array(
                                                'class' => 'button delete fl-l mr-5', 
                                                'rel' => 'nofollow',
                                                'ajax' => array(
                                                    'type' => 'post', 
                                                    'url'=>'js:$(this).attr("href")', 
                                                    'beforeSend' => 'js:function() { 
                                                                    $("#div-loading").addClass("grid-loading");
                                                                    if (!(isDel = confirm("' . Yii::t('main', 'Are you sure to delete this item') . '?")))
                                                                        $("#div-loading").removeClass("grid-loading");
                                                                    return isDel;
                                                             }',
                                                    'success' => 'js:function(data) { 
                                                        $.fn.yiiGridView.update("magazine-grid");
                                                        $("#div-loading").removeClass("grid-loading");
                                                    }'
                                                    )
                                           ),
                                           'htmlTemplate' => '<span><b></b></span>',
                                           ), 

                           'update'  => array(
                                            'label'=>Yii::t("main", "Update"),
                                            'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->magazine_id))',
                                            'options' => array('class' => 'button edit fl-l mr-5', 'rel' => 'nofollow'),
                                            'htmlTemplate' => '<span><b></b></span>',
                                           ),
                           )                                          
            ),
    )
)); 

?>