<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
        'links'=>array(
            Yii::t('main','Category')=> Yii::app()->createUrl('category'),
            Yii::t('main','Create')),
    ));


$this->menu=array(
    array('label'=>'List Category', 'url'=>array('index')),
    array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>