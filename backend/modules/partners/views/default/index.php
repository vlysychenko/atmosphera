<?
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Partners')=> Yii::app()->createUrl('partners'), 
        Yii::t('main','Index')),
));
 ?>
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
<?
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
$idGrid = 'partners-grid';
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>$idGrid,
    'type'=>'striped', //'condensed, bordered, hover',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(
            'name' => 'partner_id',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 30px'),
//            'filterInputOptions'=>array('style'=>'width: 100px'),
            'header'=> Yii::t('main', 'ID'),
            'value' => '$data->partner_id',
            'filter' => false,
        ),
        array(
            'name' => 'title',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 300px'),
//            'filterInputOptions'=>array('style'=>'width: 100px'),
//            'header'=> Yii::t('main', "Zodiac's Signs"),
            'value' => '$data->title',
//            'filter' => false,
        ),
        
        array(
            'name' => 'description',
            'type'=>'raw',
//            'htmlOptions'=>array('style'=>'width: 40px'),
//            'filterInputOptions'=>array('style'=>'width: 100px'),
//            'header'=> Yii::t('main', "Zodiac's Signs"),
            'value' => '$data->description',
            'filter' => false,
            'sortable' => false,
        ),
        array(
            'name' => 'contacts',
            'type'=>'raw',
//            'htmlOptions'=>array('style'=>'width: 40px'),
//            'filterInputOptions'=>array('style'=>'width: 100px'),
//            'header'=> Yii::t('main', "Zodiac's Signs"),
            'value' => '$data->contacts',
            'filter' => false,
            'sortable' => false,
        ),

        array(
            'htmlOptions' => array(
                'nowrap'=>'nowrap', 
                'style' => 'width: 75px'
            ),
            //'class'=>'bootstrap.widgets.TbButtonColumn',
            'class'=>'common.widgets.PButtonColumn',
            //'deleteButtonImageUrl' => false,
            //'deleteButtonIcon' => false,
            //'viewButtonIcon' => TbHtml::ICON_GLASS,
            'template' => '{update}{delete}{onoff}',
            'buttons' => array(
                'update'  => array(
                    'label'=>Yii::t("main", "Update"),
                    'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->partner_id))',
                    'options' => array(
                        'class' => 'button edit fl-l mr-5', 
                        'rel' => 'nofollow',
                    ),
                    'htmlTemplate' => '<span><b></b></span>',
                ),
                'onoff' => array(
                        'labelExpression' => '$data->is_active == 1 ?  Yii::t("main","Off"):Yii::t("main","On")',
                        'url'   =>  'Yii::app()->controller->createUrl("activate", array("id" => $data->partner_id, "on" => (!$data->is_active) ? 1:0))',
                        'cssClassExpression' => '$data->is_active == 1 ? "button on fl-l mr-5" : "button off fl-l mr-5"',
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
                                    $.fn.yiiGridView.update("partners-grid");
                                    $("#div-loading").removeClass("grid-loading");
                                }'
                            ), 
                        ),
                        'htmlTemplate' => '<span><b></b></span>',
                ),
                'delete'   => array(
                    'label'=>Yii::t("main","Delete"),
                    'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->partner_id))',
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
                                $.fn.yiiGridView.update("partners-grid");
                                $("#div-loading").removeClass("grid-loading");
                            }'
                            )
                    ),
                    'htmlTemplate' => '<span><b></b></span>',
                ),
            )                                          
        ),
    )
)); ?>
