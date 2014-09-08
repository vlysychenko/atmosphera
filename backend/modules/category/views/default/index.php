<?php 
/* @var $this DefaultController */


$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Categories')=> Yii::app()->createUrl('category'), 
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
    'id'=>'category-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$model,
    'template'=>"{items}\n{pager}",
    'type'=>'striped', //'condensed, bordered, hover',
    'htmlOptions' => array('class' => 'table-list'),
    //'itemsCssClass'=>'table-list',  
    'rowCssClassExpression' => '($row % 2 ? "even" : "odd")." bColor pt-5 pb-5 pl-10 pr-10 mb-5"',
    'columns'=>array(  
        array(
            'name'=>'category_id',
            'type'=>'raw',
            'value'=>'$data->category_id',
        ),
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'$data->name',

        ),

        array(
            'htmlOptions' => array(
                'nowrap'=>'nowrap',
                 'style' => 'width: 75px'
            ),
            'class'=>'common.widgets.PButtonColumn',
            'deleteButtonImageUrl' => false,
            'deleteButtonIcon' => false,
            'template' => '{update}{delete}',
            'buttons' => array(
                            
                           'delete'   => array(
                                           'label'=>Yii::t("main","Delete"),
                                           'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->category_id))',
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
                                                        $.fn.yiiGridView.update("category-grid");
                                                        $("#div-loading").removeClass("grid-loading");
                                                    }'
                                                    )
                                           ),
                                           'htmlTemplate' => '<span><b></b></span>',
                                           ), 

                           'update'  => array(
                                            'label'=>Yii::t("main", "Update"),
                                            'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->category_id))',
                                            'options' => array('class' => 'button edit fl-l mr-5', 'rel' => 'nofollow'),
                                            'htmlTemplate' => '<span><b></b></span>',
                                           ),
                           )                                          
            ),
                        )
    )); 
