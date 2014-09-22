 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?=Yii::app()->createAbsoluteUrl('images/favicon.ico')?>">    
    <title><?=Yii::t('main','Admin console')?></title>

    <?php 
       Yii::app()->bootstrap->registerCoreCss();
       Yii::app()->bootstrap->registerAllScripts();
       Yii::app()->clientScript->registerCSSFile(Yii::app()->createAbsoluteUrl('/').'/css/main.css');
    ?>
</head>
<body>
    <div id="top">
        <?php
        echo '<div style="margin-left: 355px;">';
            $this->widget('bootstrap.widgets.TbHeroUnit', array(
                'heading' => 'Atmosphera',
                'content' => Yii::t('main','Admin console') . TbHtml::link(Yii::t('main','Logout'), Yii::app()->createAbsoluteUrl('user/logout'), array('color' => TbHtml::BUTTON_COLOR_INVERSE,'class'=>'btn fl-r')),
                'htmlOptions'=>array(
                    'style'=>'width:1080px; padding-top: 10px; height: 50px; margin-bottom: 0;'
                ),
            ));
        echo '</div>';
        ?>
    </div>

    <div id="main" class="clearfix" style="margin: 0 auto; width: 90%;">
        <div id="column" class="clearfix">
            <div id="page" class="backend-page">
                    <div class="well mr-20" style="max-width: 340px; padding: 8px 0; float: left">
                        <?php 
                            $controllerId=Yii::app()->controller->uniqueId;
                                echo TbHtml::navList(array(
//                                array('label' => 'List header'), todo: ??
                                array('label' => Yii::t('main','Users'),     'icon' => 'user',   'url' =>  Yii::app()->createAbsoluteUrl('user/admin'), 'active' => $controllerId == 'user/admin'),
                                array('label' => Yii::t('main','Main page'),  'icon' => 'asterisk','url' =>  Yii::app()->createAbsoluteUrl('mainpage'), 'active' => $controllerId == 'mainpage/default'),
                                array('label' => Yii::t('main','Design'),  'icon' => 'th','url' =>  Yii::app()->createAbsoluteUrl('design'), 'active' => $controllerId == 'design/default'),
                                array('label' => Yii::t('main','Category'),  'icon' => 'tasks','url' =>  Yii::app()->createAbsoluteUrl('category'), 'active' => $controllerId == 'category/default'),
                                array('label' => Yii::t('main','Blog'),      'icon' => 'edit',   'url' => Yii::app()->createAbsoluteUrl('news'), 'active' => $controllerId == 'news/default'),
                                array('label' => Yii::t('main','Portfolio'), 'icon' => 'picture','url' => Yii::app()->createAbsoluteUrl('portfolioposts'), 'active' => $controllerId == 'portfolioposts/default'),
                                array('label' => Yii::t('main','Comments'),  'icon' => 'pencil', 'url' =>  Yii::app()->createAbsoluteUrl('comments'), 'active' => $controllerId == 'comments/default'),
//                                array('label' => Yii::t('main','Magazines'), 'icon' => 'book',   'url' =>  Yii::app()->createAbsoluteUrl('magazine'), 'active' => $controllerId == 'magazine/default'),
                                array('label' => Yii::t('main','Tag'),       'icon' => 'tag',    'url' =>  Yii::app()->createAbsoluteUrl('tag'), 'active' => $controllerId == 'tag/default'),
//                                array('label' => Yii::t('main','Horoscope'), 'icon' => 'globe',  'url' =>  Yii::app()->createAbsoluteUrl('horoscope'), 'active' => $controllerId == 'horoscope/default'),
//                                array('label' => Yii::t('main','Partners'),  'icon' => 'briefcase','url' =>  Yii::app()->createAbsoluteUrl('partners'), 'active' => $controllerId == 'partners/default'),
//                                array('label' => Yii::t('main','Banners'),   'icon' => 'flag',   'url' =>  Yii::app()->createAbsoluteUrl('banners'), 'active' => $controllerId == 'banners/default'),
                                array('label' => Yii::t('main','Contacts'),  'icon' => 'envelope','url' =>  Yii::app()->createAbsoluteUrl('contacts'), 'active' => $controllerId == 'contacts/default'),
                                array('label' => Yii::t('main','About Us'),  'icon' => 'star',   'url' =>  Yii::app()->createAbsoluteUrl('about'), 'active' => $controllerId == 'about/default'),
                                //array(TbHtml::menuDivider()),
                            )); 
                        ?>
                    </div>
                    
                <div id="column-background"></div>
                <div id="content" class="clearfix mb-200">
                    <?=$content?>
                </div>
            </div>
        </div>
    </div>
</html>