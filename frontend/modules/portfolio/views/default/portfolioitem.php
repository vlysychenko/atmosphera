<?php 
    $url = yii::app()->createAbsoluteUrl('portfolio/default/view/id/'.$data['post_id']);
    $anounce = $data['anounce'];
    $imgUrl = ImageHelper::imageUrl('portfolio_index_frontend', $data['filename']);
    $title = ContentHelper::cutStringEx($data['p_title'], 100);
    $timestamp = CDateTimeParser::parse($data['publication_date'], 'yyyy-MM-dd hh:mm:ss');
    $date = Yii::app()->dateFormatter->format('d MMMM y', $timestamp);
    $author = $data['firstname'].' '.$data['lastname'];
?>

<li>
    <a href="<?=$url?>">
        <img src="<?=$imgUrl?>" alt="">
        <span>
            <span class="album-title"><?=$title?></span>
            <p><?=$data['anounce']?></p>
            <span class="album-date"><?=$author?> | <?=$date?></span>
        </span>
    </a>
</li>
