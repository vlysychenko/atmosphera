<div class="sidebar">
    <div class="journal">
<!--        --><?// $this->widget('application.widgets.GMagazineWidget.GMagazineWidget');?>
    </div>
    <div class="banners">
<!--        --><?//$this->widget('application.widgets.ADWidget.ADWidget',array('countBanners'=>3));?>
<!--        <a href="#"><img src="images/photo/banner1.jpg" alt=""/></a>-->
<!--        <a href="#"><img src="images/photo/banner1.jpg" alt=""/></a>-->
<!--        <a href="#"><img src="images/photo/banner1.jpg" alt=""/></a>-->
    </div>
    <div class="categories">
<!--    --><?// $this->widget('application.widgets.GHoroscope.GHoroscopeWidget');?>
<!--        --><?php //$this->widget('application.widgets.NewsOnMainWidget.NewsOnMain');?>
        <?php

        $checkController = Yii::app()->controller->uniqueId;
        if($checkController === 'design/default'){
            $this->widget('application.widgets.CategoryWidget.CategoryForDesign');
        }else $this->widget('application.widgets.NewsOnMainWidget.NewsOnMain');

        ;?>
<!--        <img src="images/horoscope/taurus.png" alt="taurus"/>
        <div>
            <a href="<? //echo Yii::app()->createAbsoluteUrl('horoscope')?>">Гороскоп</a>
            <p>BBC Two HD to launch in BBC Two
                HD to launch in
                March as BBC HD channel
                is axed
                March as BBC HD channel
                is axed BBC Two HD to launch in
                March as BBC HD channel
                is axed
                BBC Two HD to launch in
                March as BBC HD channel
                is axedBBC Two HD to launch in
                March as BBC HD channel
                is axed</p>
        </div>-->
    </div>
</div>