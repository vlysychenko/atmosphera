<?php
/* @var $this HoroscopeController */
/* @var $model Horoscope */

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links'=>array(
        Yii::t('main','Horoscope')=> Yii::app()->createUrl('horoscope'), 
        Yii::t('main','Update')),
));
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'gallery'=>$gallery)); ?>