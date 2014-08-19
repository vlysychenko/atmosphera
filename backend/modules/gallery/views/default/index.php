<?php 
/* @var $this DefaultController */

$this->breadcrumbs=array(
    $this->module->id,
);
?>

<div class="page-title">
    <span class="fw-n"><?=Yii::t('main', 'Galleries')?></span>
</div>

<?
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
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'gallery-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'type'=>'striped', //'condensed, bordered, hover',
//    'cssFile'=>Yii::app()->createAbsoluteUrl('/').'/css/bootstrap.css',
    'htmlOptions' => array('class' => 'table-list'),
    //'itemsCssClass'=>'table-list',  
    'rowCssClassExpression' => '($row % 2 ? "even" : "odd")." bColor pt-5 pb-5 pl-10 pr-10 mb-5"',
    'template'=>"{pager}\n{items}\n{pager}",
    'columns'=>array(
        array(
            'name' => 'gallery_id',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 50px'),
            'header'=>'ID', 
            'value' => 'CHtml::link(CHtml::encode($data->gallery_id),array("gallery/default/update","id"=>$data->gallery_id))',
        ),
        array(
            'name'=>'title',
            'type'=>'raw',
//            'htmlOptions'=>array('style'=>'width: 250px'),
            'value'=>'$data->title',
        ),
        array(
            'name'=>'description',
            'type'=>'raw',
//            'htmlOptions'=>array('style'=>'width: 250px'),
            'value'=>'$data->title',
        ),
        array(
            'htmlOptions' => array('nowrap'=>'nowrap', 'style' => 'width: 130px'),
            'class'=>'common.widgets.PButtonColumn',
            'deleteButtonImageUrl' => false,
            'deleteButtonIcon' => false,
            'template' => '{update}{delete}{onoff}',
            //'template' => '{onoff}',
            'buttons' => array('onoff' => array(
                                            'labelExpression' => '$data->is_active == 1 ?  Yii::t("main","Off"):Yii::t("main","On")',
                                            'url'   =>  'Yii::app()->controller->createUrl("activate", array("id" => $data->gallery_id, "on" => (!$data->is_active) ? 1:0))',
                                            'cssClassExpression' => '$data->is_active == 1 ? "button" : "button"',
                                            /*'options' => array(
                                                'rel' => 'nofollow',
                                                'ajax' => array(
                                                    'type' => 'get', 
                                                    'url'=>'js:$(this).attr("href")', 
                                                    'beforeSend' => 'js:function() { 
                                                                    $("#div-loading").addClass("grid-loading");
                                                                    return true;
                                                             }',
                                                    'success' => 'js:function(data) { 
                                                        $.fn.yiiGridView.update("gallery-grid");
                                                        $("#div-loading").removeClass("grid-loading");
                                                    }'
                                                ), 
                                            ),*/
                                            //'htmlTemplate' => '<span><b></b></span>',
                                           ),

                            
                           'delete'   => array(
                                           'label'=>Yii::t("main","Delete"),
                                           'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->gallery_id))',
                                           /*'options' => array(
                                                //'class' => 'button delete fl-l mr-5', 
                                                //'rel' => 'nofollow',
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
                                                        $.fn.yiiGridView.update("gallery-grid");
                                                        $("#div-loading").removeClass("grid-loading");
                                                    }'
                                                    )
                                           ),*/
                                           //'htmlTemplate' => '<span><b></b></span>',
                                           ), 

                           'update'  => array(
                                            'label'=>Yii::t("main", "Update"),
                                            'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->gallery_id))',
                                            //'options' => array('class' => 'button edit fl-l mr-5', 'rel' => 'nofollow'),
                                            //'htmlTemplate' => '<span><b></b></span>',
                                           ),
                           )                                          
            ),
    )
)); 

?>