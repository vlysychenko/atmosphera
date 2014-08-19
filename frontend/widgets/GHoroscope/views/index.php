<?php
    $imgUrl = ImageHelper::imageUrl('thumb_horoscope',$data['filename']);
?>
<img src="<?=$imgUrl?>" alt="<?=$data['title']?>" title="<?=$data['title']?>"/>
<div>
    <a href="<?=Yii::app()->createAbsoluteUrl('horoscope')?>">Гороскоп</a>
    <?=$data['content']?>
</div>