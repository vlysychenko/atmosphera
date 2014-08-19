<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Администрирование</title>
    <? //include (dirname(dirname(dirname(__FILE__)))."/www/ssi/scripts.html");     ?>
    <? 
       //Yii::app()->clientScript->registerCSSFile(Yii::app()->request->baseUrl. '/css/access.css');
       Yii::app()->clientScript->registerCSSFile(Yii::app()->request->baseUrl. '/css/main.css');
       Yii::app()->clientScript->registerCSSFile(Yii::app()->request->baseUrl. '/css/pattern-rtl/main.css');
       Yii::app()->clientScript->registerCSSFile(Yii::app()->request->baseUrl. '/js/date/ui.all.css');
    ?>
</head>
<body>
    <? include (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/www/ssi/top.html"); 
        //$this->renderpartial
    ?> 
    <div id="main" class="clearfix">
        <div id="column" class="clearfix">
            <div id="page">
                <? include (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/www/ssi/navigation.html"); ?>
                <? echo $content; ?>           
            </div>
        </div>
        <? include (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/www/ssi/bottom.html"); ?>   
    </div>
</body>
</html>