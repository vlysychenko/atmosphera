<?$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(Yii::t('main','Tag')=> Yii::app()->createUrl('tag'), Yii::t('main','Tag detail')),
));
echo Yii::t('main','Selest Tag:').' ';
echo CHtml::dropDownList('tags-list','', Tag::getListTag(), array(
    'id' => 'tags_filter',
    'options'=>array($tagId=>array('selected'=>'selected')
    )));

$dateFilter = $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
    'name'=>'News[publication_date]',
    'value'=>$pbDate,
    'pluginOptions' => array(
        'format' => 'yyyy-mm-dd',
    ),
    'htmlOptions' => array(
        'id'=>'News_publication_date',
    ),
), true);

$js = '$("#tags_filter").change(
        function(){
            tag_value = $("#tags_filter").attr("value");
            if(tag_value.length)
                tag_value = "/id/" + tag_value;
            ajaxdata = tag_value;
            window.location.replace("'.yii::app()->createUrl('tag/default/tagdetail').'" + ajaxdata);
        });
        $("#tags_filter").attr("value", "'.$tagId.'");';

Yii::app()->getClientScript()->registerScript('filter', $js, CClientScript::POS_READY);

echo '<div id="div-loading" class=""></div>';
$idGrid = 'tagdetail-grid';

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'tagdetail-grid',
    'dataProvider'=>$dataprovider,
    'filter'=>$model,
    'type'=>'striped', //'condensed, bordered, hover',
    'htmlOptions' => array('class' => 'table-list'),
    'rowCssClassExpression' => '($row % 2 ? "even" : "odd")',
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'template'=>"{pager}\n{items}\n{pager}",
    'columns'=>array(
        array(
            'name'=>'post_id',
            'header'=>'ID',
//            'filter'=> false,
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'width: 250px'),
            'value' => '$data->post_id',
        ),
        array(
            'name'=>'title',
            'header'=>Yii::t('main','Title'),
            'type'=>'raw',
//            'filter'=>'',
            'htmlOptions'=>array('style'=>'width: 250px'),
            'value'=>'$data->title',
        ),
        array(
            'name'=>'post_type',
            'header'=>Yii::t('main','Post type'),
            'type'=>'raw',
            'filter'=>CHtml::listData($model->typePosts(), 'id', 'post_type'),
            'htmlOptions'=>array('style'=>'width: 250px'),
            'value'=>'$data->post_type == 1 ? Yii::t("main","News") : Yii::t("main","Portfolio")',
        ),
        array(
            'name'=>'publication_date',
            'header'=>Yii::t('main','Publication date'),
            'type'=>'raw',
            'filter'=>$dateFilter,
            'htmlOptions'=>array('style'=>'width: 250px'),
            'value'=>'$data->publication_date',
        ),
    )));

$js = 'function onBeforeSend() {
            $("#div-loading").addClass("grid-loading");
            return true;
       }
       function onSuccess(data) {
            $.fn.yiiGridView.update("'.$idGrid.'");
            $("#div-loading").removeClass("grid-loading");
       }';

Yii::app()->getClientScript()->registerScript('jsLoading', $js);


Yii::app()->clientScript->registerScript('re-install-date-picker', "
        function reinstallDatePicker(id, data) {
            //$('#News_publication_date').datepicker($.datepicker.regional['ru']);
            $('#News_publication_date').datepicker({format: 'yyyy-mm-dd'});
        }
    ");

?>