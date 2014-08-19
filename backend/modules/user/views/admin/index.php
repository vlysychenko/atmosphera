<?$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(Yii::t('main','User')=> Yii::app()->createUrl('user/admin'), Yii::t('main','Manage Users')),
//'homeLink' => '',
));?>
<div style="display: block; overflow: hidden !important;">
    <?php
    echo CHtml::link('<span class="pl-10 pr-10">'.Yii::t('main','Add User').'</span>', Yii::app()->controller->createUrl("create"), array(
        'id' => 'btnAdd',
        'class' => 'btn fl-r mt-10 mb-10',
    ));  
    ?>
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
    'id'=>'users-grid',
	'dataProvider'=>$model->search(),
    'filter'=>$model,
    'type'=>'striped', //'condensed, bordered, hover',
    'htmlOptions' => array('class' => 'table-list'),
    'rowCssClassExpression' => '($row % 2 ? "even" : "odd")',
    'template'=>"{pager}\n{items}\n{pager}",
	'columns'=>array(
		array(
			'name' => 'user_id',
			'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 50px'),
            'header'=>'ID',
			'value' => 'CHtml::link(CHtml::encode($data->user_id),array("admin/update","id"=>$data->user_id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 250px'),
			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
		),
        array(
            'name' => 'lastname',
            'htmlOptions'=>array('style'=>'width: 100px'),
            'value' => '$data->lastname',
        ),
        array(
            'name' => 'firstname',
            'htmlOptions'=>array('style'=>'width: 100px'),
            'value' => '$data->firstname',
        ),
		/*array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
            'htmlOptions'=>array('style'=>'width: 150px'),
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
		),
		array(
			'name'=>'status',
            'htmlOptions'=>array('style'=>'width: 100px'),
			'value'=>'User::itemAlias("UserStatus",$data->status)',
		), */
        
        array(
//            'htmlOptions' => array('nowrap'=>'nowrap', 'style' => 'width: 80px;'),
//            'class'=>'CButtonColumn',
            'class'=>'common.widgets.PButtonColumn',
//            'class'=>'bootstrap.widgets.TbButtonColumn',
            'deleteButtonImageUrl' => false,
            'deleteButtonIcon' => false,
            'template' => '{onoff}{update}{delete}',
            'buttons' => array(
                            'onoff' => array(
                                            'labelExpression' => '$data->status == 1 ? Yii::t("main","Off"):Yii::t("main","On")',
                                            'url'   =>  'Yii::app()->controller->createUrl("admin", array("id" => $data->user_id, "on" => (!$data->status) ? 1:0))',
                                            'cssClassExpression' => '$data->status == 1 ? "button on fl-l mr-5" : "button off fl-l mr-5"',
                                            'options' => array(
                                                'rel' => 'nofollow',
                                                'ajax' => array(
                                                    'type' => 'get',
                                                    'url'=>'js:$(this).attr("href")',
                                                    'success' => 'js:function(data) { $.fn.yiiGridView.update("users-grid")}'
                                                ),
                                            ),
                                            'htmlTemplate' => '<span><b></b></span>',
                                            'visible' => '($data->user_id != Yii::app()->user->id) && UserModule::isAdmin()',
                                           ),
                           'delete'   => array(
                                           'label'=>Yii::t("main","Delete"),
                                           'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->user_id))',
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
                                                        alert("vvvv");
                                                        $.fn.yiiGridView.update("users-grid");
                                                    }'
                                                ),
                                           ),
                                           'htmlTemplate' => '<span><b></b></span>',
                                           'visible' => '($data->user_id != Yii::app()->user->id) && UserModule::isAdmin()',
                                           ),
                           'update'  => array(
                                            'label'=>Yii::t("main","Edit"),
                                            'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->user_id))',
                                            'options' => array('class' => 'button edit fl-l mr-5', 'rel' => 'nofollow'),
                                            'htmlTemplate' => '<span><b></b></span>',
                                            'visible' => 'UserModule::isAdmin()',
                                           ),
    )),
))); 

?>