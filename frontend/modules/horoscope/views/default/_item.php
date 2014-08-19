<?
    $imgUrl = ImageHelper::imageUrl('thumb_horoscope',$item['filename']);
    $arrOrder = explode('-', $signsOrder);
?>
<div class="content-block">
    <img width="91px" height="79px" src="<?=$imgUrl?>" alt="">
    <div>
        <div class="block-title"><?=$item['title']?></div>
        <span class="small"><?='('.$arrOrder[0].' &mdash; '.$arrOrder[1].')'?></span>
        <?=$item['content']?>
    </div>
</div>