 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?=Yii::app()->createAbsoluteUrl('images/favicon.ico')?>">    
    <title><?=Yii::t('main','Admin console')?></title>

    <?php //include (dirname(__FILE__)."/scripts.php"); 
       Yii::app()->clientScript->registerCSSFile(Yii::app()->createAbsoluteUrl('/').'/css/main.css');
       Yii::app()->bootstrap->registerCoreCss();
       Yii::app()->bootstrap->registerAllScripts();
    ?>
    <link rel="stylesheet" media="screen" href="css/main.css" >
</head>
<body>
    <div id="top">
        <?php
        echo '<div style="margin-left: 355px;">';
            $this->widget('bootstrap.widgets.TbHeroUnit', array(
                'heading' => 'Top Granat',
                'content' => Yii::t('main','Admin console').TbHtml::link('Logout', Yii::app()->createAbsoluteUrl('user/logout'), array('color' => TbHtml::BUTTON_COLOR_INVERSE,'class'=>'btn fl-r')),
                'htmlOptions'=>array('style'=>'width:1080px;')
            ));
        echo '</div>';
        ?>
    </div>
    <div id="content" class="clearfix">
        <?=$content?>
    </div>
</html>