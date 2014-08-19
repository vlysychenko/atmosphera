<?$this->widget('bootstrap.widgets.TbBreadcrumb', array(
'links'=>array(Yii::t('main','Tag')=> Yii::app()->createUrl('tag'), Yii::t('main','Index')),
//'homeLink' => '',
));?>
<div style="display: block; overflow: hidden !important;">
<?
echo CHtml::link('<span class="pl-10 pr-10">'.Yii::t('main','Create').'</span>', Yii::app()->controller->createUrl("create"), array(
    'id' => 'btnAdd',
    'class' => 'btn fl-r mt-10 mb-10',
));?>
<div style="margin-top: 10px;">
        <div id="div-loading" class=""></div>
    </div>
</div>
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

$this->widget('bootstrap.widgets.TbGridView', array(
'id'=>'tag-grid',
'dataProvider'=>$model->search(),
'type'=>'striped', //'condensed, bordered, hover',
'filter'=>$model,
'htmlOptions' => array('class' => 'table-list'),
'rowCssClassExpression' => '($row % 2 ? "even" : "odd")',
'template'=>"{items}\n{pager}",
'columns'=>array(
array(
    'name'=>'title',
    'type'=>'raw',
//    'htmlOptions'=>array('style'=>'width: 400px'),
    'value' => 'CHtml::link(CHtml::encode($data->title),array("default/tagdetail","id"=>$data->tag_id))',
//    'value'=>'$data->title',
),
array(
    'type'=>'raw',
//    'htmlOptions'=>array('style'=>'width: 400px'),
    'header'=>Yii::t('main','Count'),
    //'value' => 'CHtml::link(CHtml::encode($data->user_id),array("admin/update","id"=>$data->user_id))',
    'value' => '$data->post_count= NULL ? 0 : $data->post_count',
//'value' => '$data->post_count',
),
array(
                'htmlOptions' => array('nowrap'=>'nowrap', 'style' => 'width: 50px;'),
    //            'class'=>'CButtonColumn',
    'class'=>'common.widgets.PButtonColumn',
    //            'class'=>'bootstrap.widgets.TbButtonColumn',
    'deleteButtonImageUrl' => false,
    'deleteButtonIcon' => false,
    'template' => '{update}{delete}',
    'buttons' => array(
        'delete'   => array(
            'label'=>Yii::t("main","Delete"),
            'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->tag_id))',
            'options' => array(
                'class' => 'button delete fl-l mr-5', 'rel' => 'nofollow',
                'ajax' => array(
                    'type' => 'post',
                    'url'=>'js:$(this).attr("href")',
                    'beforeSend' => 'js:
                    function() {
                    $("#div-loading").addClass("grid-loading");
                    isDel = confirm("' . Yii::t('main', 'Are you sure to delete this item') . '?");
                    if (!isDel)
                    $("#div-loading").removeClass("grid-loading");
                    return isDel;
                    }',
                    'success' => 'js:function(data) {
                    $("#div-loading").removeClass("grid-loading");
                    $.fn.yiiGridView.update("tag-grid");
                    }'
                ),
            ),
            'htmlTemplate' => '<span><b></b></span>',
        ),
        'update'  => array(
            'label'=>Yii::t("main","Edit"),
            'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->tag_id))',
            'options' => array('class' => 'button edit fl-l mr-5', 'rel' => 'nofollow'),
            'htmlTemplate' => '<span><b></b></span>',
        ),
    )),
)));

?>