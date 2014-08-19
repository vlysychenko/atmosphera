<?php
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('CommentsModule.msg', 'Comments')=>array('index'),
        Yii::t('CommentsModule.msg', 'Manage'),
    ),
));

?>          

<!--<h1><?php //echo Yii::t('CommentsModule.msg', 'Manage Comments');?></h1>-->

<?php 
//$this->widget('zii.widgets.grid.CGridView', array(
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'comment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'type'=>'striped', //'striped, condensed, bordered, hover',
    'htmlOptions' => array('class' => 'table-list'),
    'rowCssClassExpression' => '($row % 2 ? "even" : "odd")." bColor pt-5 pb-5 pl-10 pr-10 mb-5"',
    'template'=>"{items}\n{pager}",
	'columns'=>array(
                array(
                    'name'=>'owner_name',
                    //'htmlOptions'=>array('width'=>50),
                    'htmlOptions'=>array('style'=>'width: 50px'),
                    'filterInputOptions'=>array('style'=>'width: 50px'),
                    'header'=>Yii::t('CommentsModule.msg','Object'),
                ),
                array(
                    'name'=>'owner_id',
                    //'htmlOptions'=>array('width'=>50),
                    'htmlOptions'=>array('style'=>'width: 40px'),
                    'filterInputOptions'=>array('style'=>'width: 40px'),
                    'header'=>Yii::t('main','ID'),
                ),
                array(
                    'header'=>Yii::t('CommentsModule.msg', 'User Name'),
                    'value'=>'$data->userName',
                    'htmlOptions'=>array('width'=>80),
                ),
                //array(
                //    'header'=>Yii::t('CommentsModule.msg', 'Link'),
                //    'value'=>'CHtml::link(CHtml::link(Yii::t("CommentsModule.msg", "Link"), $data->pageUrl, array("target"=>"_blank")))',
                //    'type'=>'raw',
                //    'htmlOptions'=>array('width'=>50),
		        //),
		        'comment_text',
                array(
                    'name'=>'create_time',
                    'type'=> 'raw',//'datetime',
                    //'htmlOptions'=>array('width'=>70),
                    'htmlOptions'=>array('style'=>'width: 150px'),
                    'filterInputOptions'=>array('style'=>'width: 150px'),
                    'filter'=>false,
                ),
		        //'update_time',
		        array(
                    'name'=>'status',
                    'value'=>'$data->textStatus',
                    //'htmlOptions'=>array('width'=>50),
                    'htmlOptions'=>array('style'=>'width: 100px'),
                    'filterInputOptions'=>array('style'=>'width: 100px'),
                    'filter'=>Comment::model()->getStatuses(),
                    'header'=>Yii::t('CommentsModule.msg','Status'),
                ),
		        array(
                    //'deleteButtonImageUrl'=>false,
                    'class'=>'common.widgets.PButtonColumn',
                    'htmlOptions' => array('nowrap'=>'nowrap', 'style' => 'width: 150px'),
                    'template'=>'{approve}{cancel}{delete}{restore}',
                    //'template'=>'{approve}{delete}',
                    'buttons'=>array(
                        'approve' => array(
                            //'labelExpression'=>'$data->status == Comment::STATUS_NOT_APPROVED ? Yii::t("CommentsModule.msg", "Approve") : Yii::t("CommentsModule.msg", "Cancel")',
                            //'url'=>'Yii::app()->urlManager->createUrl($data->status == Comment::STATUS_NOT_APPROVED ? CommentsModule::APPROVE_ACTION_ROUTE : CommentsModule::APPROVE_ACTION_CANCEL, array("id"=>$data->comment_id))',
                            'label'=>Yii::t('CommentsModule.msg', 'Approve'),
                            'url'=>'Yii::app()->urlManager->createUrl(CommentsModule::APPROVE_ACTION_ROUTE, array("id"=>$data->comment_id))',
                            'visible'=>'$data->status == Comment::STATUS_NOT_APPROVED',
                            //'cssClassExpression' => '$data->status == Comment::STATUS_NOT_APPROVED ? "button off fl-l mr-5" : "button on fl-l mr-5"',
                            'htmlTemplate' => '<span><b></b></span>',
                            'options'=>array(
                                'class' => 'button off fl-l mr-5', 
                                'rel' => 'nofollow',
                            ),
                            'click'=>'function(){
                                if(confirm("'.Yii::t('CommentsModule.msg', 'Approve this comment?').'"))
                                {
                                    $.post($(this).attr("href")).success(function(data){
                                        data = $.parseJSON(data);
                                        if(data["code"] === "success")
                                        {
                                            $.fn.yiiGridView.update("comment-grid");
                                        }
                                    });
                                }
                                return false;
                            }',
                        ),

                        'cancel' => array(
                            'label'=>Yii::t('CommentsModule.msg', 'Cancel'),
                            'url'=>'Yii::app()->urlManager->createUrl(CommentsModule::APPROVE_ACTION_CANCEL, array("id"=>$data->comment_id))',
                            'visible'=>'$data->status == Comment::STATUS_APPROVED',
                            //'cssClassExpression' => '$data->status == Comment::STATUS_NOT_APPROVED ? "button off fl-l mr-5" : "button on fl-l mr-5"',
                            'htmlTemplate' => '<span><b></b></span>',
                            'options'=>array(
                                'class' => 'button on fl-l mr-5', 
                                'rel' => 'nofollow',
                            ),
                            'click'=>'function(){
                                if(confirm("'.Yii::t('CommentsModule.msg', 'Cancel this comment?').'"))
                                {
                                    $.post($(this).attr("href")).success(function(data){
                                        data = $.parseJSON(data);
                                        if(data["code"] === "success")
                                        {
                                            $.fn.yiiGridView.update("comment-grid");
                                        }
                                    });
                                }
                                return false;
                            }',
                        ),

                        'delete'   => array(
                           'label'=>Yii::t("main","Delete"),
                           'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->comment_id))',
                           'htmlTemplate' => '<span><b></b></span>',
                           'visible'=>'$data->status == Comment::STATUS_NOT_APPROVED',
                           'options' => array(
                                'class' => 'button delete fl-l mr-5', 
                                'rel' => 'nofollow',
                                /*'ajax' => array(
                                    'type' => 'post', 
                                    'url'=>'js:$(this).attr("href")', 
                                    'beforeSend' => 'js:function() { 
                                                    if ((isDel = confirm("' . Yii::t('main', 'Are you sure to delete this item') . '?")))
                                                        loadingShow();
                                                    else
                                                        loadingHide();
                                                    return isDel;
                                             }',
                                    'success' => 'js:onSuccess', 
                                )*/
                           ),
                        ), 
                        
                        'restore'   => array(
                           'label'=>Yii::t("main","Restore"),
                           'url' => 'Yii::app()->controller->createUrl("restore", array("id" => $data->comment_id))',
                           'htmlTemplate' => '<span><b></b></span>',
                           'visible'=>'$data->status == Comment::STATUS_DELETED',
                           'options' => array(
                                'class' => 'button view fl-l mr-5', 
                                'rel' => 'nofollow',
                           ),
                           'click'=>'function(){
                                if(confirm("'.Yii::t('CommentsModule.msg', 'Restore this comment?').'"))
                                {
                                    $.post($(this).attr("href")).success(function(data){
                                        data = $.parseJSON(data);
                                        if(data["code"] === "success")
                                        {
                                            $.fn.yiiGridView.update("comment-grid");
                                        }
                                    });
                                }
                                return false;
                            }',
                        ), 
                    ),
		        ),
	),
)); ?>
