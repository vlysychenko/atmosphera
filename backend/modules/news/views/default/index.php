<?php 
/* @var $this DefaultController */

//get model class for view customizing
$modelClass = get_class($model);

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
            Yii::t('main',ucfirst($this->module->id))=> Yii::app()->createUrl($this->module->id),
            Yii::t('main',ucfirst($this->action->id)),
    ),
));
?>

<?php echo CHtml::link('<span class="pl-10 pr-10">'.Yii::t('main','Create').'</span>', Yii::app()->controller->createUrl("create"), array(
        'id' => 'btnAdd',
        'class' => 'btn fl-r mt-10 mb-10',
    )); ?>
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
$idGrid = 'news-grid';

$dateFilter = $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                    'name'=>$modelClass.'[publication_date]',
                    'value'=>$model->publication_date,
                    'pluginOptions' => array(
                        'format' => 'yyyy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'id'=>$modelClass.'_publication_date',
                    ),
                ), true);

    $columns = array(
        array(
            'name' => 'post_id',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 40px'),
            'filterInputOptions'=>array('style'=>'width: 40px'),
            //'header'=>Yii::t('main','ID'), 
            //'value' => 'CHtml::link(CHtml::encode($data->post_id),array("portfolio/default/update","id"=>$data->post_id))',
        ),
        array(
            'name'=>'publication_date',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 150px'),
            'filter'=>$dateFilter,
            'filterInputOptions'=>array('style'=>'width: 150px'),
            'value'=>'$data->publication_date',
        ),
        array(
            'name'=>'post_id',
            'header'=>Yii::t('main','Title'),
            'type'=>'raw',
            'value'=>'$data->post->title',
            'filter'=>'<input id="'.$modelClass.'_postTitle" type="text" name="'.$modelClass.'[postTitle]" value="' . $model->postTitle . '">',
        ),
        array(
            'name'=>'user_id',
            'header'=>Yii::t('main','Author'),
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 250px'),
            'filterInputOptions'=>array('style'=>'width: 250px'),
            'value'=>'$data->author->email',
            'filter'=>'<input id="'.$modelClass.'_postAuthor" type="text" name="'.$modelClass.'[postAuthor]" value="' . $model->postAuthor . '">',
        ),
    );
    
    $buttoncolumn = array(
            'htmlOptions' => array('nowrap'=>'nowrap', 'style' => 'width: 150px'),
            'class'=>'common.widgets.PButtonColumn',
            //'deleteButtonImageUrl' => false,
            //'deleteButtonIcon' => false,
            'template' => ($modelClass == 'News' ? '{update}{delete}{active}{top}{slider}' : '{update}{delete}{active}{top}') ,
            'buttons' => array('active' => array(
                                            'labelExpression' => '$data->post->is_active == 1 ?  Yii::t("main","Off") : Yii::t("main","On")',
                                            'url' => 'Yii::app()->controller->createUrl("setstatus", array("id" => $data->post_id, "is_active" => (!$data->post->is_active) ? 1:0))',
                                            'cssClassExpression' => '$data->post->is_active == 1 ? "button on fl-l mr-5" : "button off fl-l mr-5"',
                                            'options' => array(
                                                'rel' => 'nofollow',
                                                'ajax' => array(
                                                    'type' => 'get', 
                                                    'url'=>'js:$(this).attr("href")', 
                                                    'beforeSend' => 'js:onBeforeSend', 
                                                    'success' => 'js:onSuccess', 
                                                ), 
                                            ),
                                            'htmlTemplate' => '<span><b></b></span>',
                                           ),

                               'top' => array(
                                            'labelExpression' => '$data->is_top == 0 ?  Yii::t("main","Make top") : Yii::t("main","Make usual")',
                                            'url' => 'Yii::app()->controller->createUrl("setstatus", array("id" => $data->post_id, "is_top" => (!$data->is_top) ? 1:0))',
                                            'cssClassExpression' => '$data->is_top > 0 ? "button watch on fl-l mr-5" : "button watch off fl-l mr-5"',
                                            'options' => array(
                                                'rel' => 'nofollow',
                                                'ajax' => array(
                                                    'type' => 'get', 
                                                    'url'=>'js:$(this).attr("href")', 
                                                    'beforeSend' => 'js:onBeforeSend', 
                                                    'success' => 'js:onSuccess', 
                                                ), 
                                            ),
                                            'htmlTemplate' => '<span><b></b></span>',
                                           ),                                           
                            
                               'slider' => array(
                                            'labelExpression' => '$data->is_slider == 0 ?  Yii::t("main","Show in slider") : Yii::t("main","Delete from slider")',
                                            'url' => 'Yii::app()->controller->createUrl("setstatus", array("id" => $data->post_id, "is_slider" => (!$data->is_slider) ? 1:0))',
                                            'cssClassExpression' => '$data->is_slider > 0 ? "button informer on fl-l mr-5" : "button informer off fl-l mr-5"',
                                            'options' => array(
                                                'rel' => 'nofollow',
                                                'ajax' => array(
                                                    'type' => 'get', 
                                                    'url'=>'js:$(this).attr("href")', 
                                                    'beforeSend' => 'js:onBeforeSend',
                                                    'success' => 'js:onSuccess', 
                                                ), 
                                            ),
                                            'htmlTemplate' => '<span><b></b></span>',
                                           ),                                           

                           'delete'   => array(
                                           'label'=>Yii::t("main","Delete"),
                                           'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->post_id))',
                                           'options' => array(
                                                'class' => 'button delete fl-l mr-5', 
                                                'rel' => 'nofollow',
                                                'ajax' => array(
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
                                                    )
                                           ),
                                           'htmlTemplate' => '<span><b></b></span>',
                                           ), 

                           'update'  => array(
                                            'label'=>Yii::t("main", "Edit"),
                                            'url' => 'Yii::app()->controller->createUrl("update", array("id" => $data->post_id))',
                                            'options' => array(
                                                'class' => 'button edit fl-l mr-5', 
                                                'rel' => 'nofollow',
                                            ),
                                            'htmlTemplate' => '<span><b></b></span>',
                                           ),
                           )                                          
            );
    
    if ($modelClass == 'PortfolioPosts') {
        $columns[] = array(
            'header'=>Yii::t('main','Photos'),//TbHtml::small(Yii::t('main','Photo count')),
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 40px'),
            'value'=>'$data->post->portfolio->photoCount',
        );
    }
    
    $columns[] = $buttoncolumn;
                
                
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>$idGrid,
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'type'=>'striped', //'striped, condensed, bordered, hover',
    'htmlOptions' => array('class' => 'table-list'),
    'rowCssClassExpression' => '($row % 2 ? "even" : "odd")." bColor pt-5 pb-5 pl-10 pr-10 mb-5"',
    'template'=>"{items}\n{pager}",
    'beforeAjaxUpdate' => 'onBeforeSend',
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'columns'=>$columns,
    )
); 

$js = '
       function loadingShow() {
            $("#div-loading").addClass("grid-loading");
       }
       function loadingHide() {
            $("#div-loading").removeClass("grid-loading");
       }

       function onBeforeSend() { 
            loadingShow()
            return true;
       }
       function onAfterSend(data) { 
            loadingHide();
       }
       function onSuccess(data) { 
            $.fn.yiiGridView.update("'.$idGrid.'");
            loadingHide();
       }';
Yii::app()->getClientScript()->registerScript('jsLoading', $js); 

//$js1 = "jQuery.datepicker.regional['ru'].dateFormat = 'yyyy-mm-dd';";
//Yii::app()->getClientScript()->registerScript('setDateFormat', $js1, CClientScript::POS_END);

Yii::app()->clientScript->registerScript('re-install-date-picker', "
        function reinstallDatePicker(id, data) {
            $('#".$modelClass."_publication_date').datepicker({format: 'yyyy-mm-dd'});
            onAfterSend();
        }
    ");


?>