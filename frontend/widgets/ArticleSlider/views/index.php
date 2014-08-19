<ul class="album-list article-album">
<? foreach($data as $article){?>
    <? 
        $arr = explode(' ', $article['publication_date']);
        $timestamp = CDateTimeParser::parse($article['publication_date'], 'yyyy-MM-dd hh:mm:ss');
        $date = Yii::app()->dateFormatter->format('d MMMM y', $timestamp);
        $title = ContentHelper::cutStringEx($article['p_title'], 100);
        $imgUrl = ImageHelper::imageUrl('article_slider',$article['filename'])
    ?>
    <li title="<?=$title?>">
        <a href="<?=Yii::app()->createAbsoluteUrl('articles/default/view', array('id'=>$article['id']))?>">
            <img style="width: 335px; height: 228px;" src="<?=$imgUrl?>" alt="<?=$title?>" title="<?=$title?>">
            <span>
                <span class="album-title"><?=$title?></span>
                <span class="album-date"><?=$article['firstname'].' '.$article['lastname'].' | '.$date?></span>
            </span>
        </a>
    </li>
<? } ?>
</ul>