<!doctype html>
<!--[if lte IE 8]><html class="lteie8"><![endif]-->
<!--[if gt IE 8]><!--><html><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title><?=ContentHelper::prepareStr(Yii::app()->getController()->getTitle())?></title>
    <meta name="Description" content="<?=ContentHelper::prepareStr(Yii::app()->getController()->getDescription())?>" />
    <meta name="KeyWords" content="<?=ContentHelper::prepareStr(Yii::app()->getController()->getKeywords())?>" />
    <meta name="viewport" content="width=device-width"/>
    <link rel="stylesheet" media="screen" href="<?=Yii::app()->createAbsoluteUrl('/')?>/css/style.css" >
    <!--[if lt IE 9]><script src="/js/html5.js"></script><![endif]-->
    <?php 
        Yii::app()->clientScript->registerCoreScript('jquery');
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->createAbsoluteUrl('/js/jquery-1.9.1.min.js'));        
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->createAbsoluteUrl('/js/home.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->createAbsoluteUrl('/js/swfobject.js'));
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->createAbsoluteUrl('/js/slides.min.jquery.js'));
    ?>
    <script type="text/javascript">
        swfobject.registerObject("flBanner", "9.0.0");
    </script>
</head>
<body>
    <div id="wrapper">
        <div class="inner">
            <div id="header">
             <?php
              $controllerId=Yii::app()->controller->uniqueId;             
                    if ($controllerId != 'home/default' && $controllerId != 'site') 
                        echo CHtml::link('', Yii::app()->createAbsoluteUrl('/'), array('class'=>'logo'));
                    else 
                        echo CHtml::tag('h1', array('class'=>'logo'), '', true);
                ?>                           
                <!--<h1 class="logo">Atmosphera</h1>-->
                <div class="main-nav">
                <div class="header-block">
                    <ul class="social">
                        <?$links = Yii::app()->getController()->prepareSocialLinks();?>
                        <li><a class="vk" href="<?=$links['vk'] ? $links['vk'] : ''?>">Vkontakte</a></li>
                        <li><a class="fb" href="<?=$links['facebook'] ? $links['facebook'] : ''?>">Facebook</a></li>
                    </ul>
                </div>
                <span></span>                
                     <ul class="menu">
                        <li><a href="<?=Yii::app()->createAbsoluteUrl('portfolio')?>"><?=Yii::t('main','portfolio')?></a></li>
                        <li><a href="<?=Yii::app()->createAbsoluteUrl('partners')?>"><?=Yii::t('main','partners')?></a></li>
                        <li><a href="<?=Yii::app()->createAbsoluteUrl('about')?>"><?=Yii::t('main','about us')?></a></li>
                        <li><a href="<?=Yii::app()->createAbsoluteUrl('blogs')?>"><?=Yii::t('main','blogs')?></a></li>
                        <li><a href="<?=Yii::app()->createAbsoluteUrl('contacts')?>"><?=Yii::t('main','contacts')?></a></li>
                    </ul>
                </div>
            </div>
            <div id="main">
            <!--   Content      -->
                <?=$content?>
            <!--    Sidebar     -->
                <? include (dirname(__FILE__)."/sidebar.php"); 
                ?>
            </div>
            <div id="footer">
                <div class="inner">
                    <span>партнеры</span>
            <?
              $this->widget('frontend.extensions.bxslider.BxSlider',array(
              'slides'=> $this->preparePartnerSlides(),
              'id' => 'partners-portfolio-slider',
              'htmlOptions' => array('class' => 'slider-article'),
              'sliderOptions'=> array('pager' => false,
                            'slideWidth' => 125,
                            'minSlides' => 2,
                            'maxSlides' => 8,
                            'auto' => false,
                            'infiniteLoop' => false,
                           ),
              'sliderHtmlOptions'=> array(),
              ));
            ?>
                </div>
                <div style="text-align: center; margin-top: 10px;">
                    <div style="float: right; margin-right: 20px;">Сайт разработан компанией <a style="color:#000; " target="_blank" href="http://academysmart.com.ua/">ООО "Академия Смарт"</a></div>                
                    <a style="color: #FFFFFF; position: relative; left: 160px;" href="<?=Yii::app()->createAbsoluteUrl('sitemap')?>">Карта сайта</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>