<?
    $this->widget('application.widgets.SearchWidget.GoogleSearch', array('query' => $query));
    
    if(strlen($query)) {
        Yii::app()->clientScript->registerScript('firstSearch', '$("#submitButton").click()', CClientScript::POS_LOAD);
    }
?>