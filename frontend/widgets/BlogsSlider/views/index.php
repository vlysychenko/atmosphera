<ul class="album-list article-album">
<? foreach($data as $blogs){?>
    <? 
        $arr = explode(' ', $blogs['publication_date']);
        $timestamp = CDateTimeParser::parse($blogs['publication_date'], 'yyyy-MM-dd hh:mm:ss');
        $date = Yii::app()->dateFormatter->format('d MMMM y', $timestamp);
        $title = ContentHelper::cutStringEx($blogs['p_title'], 100);
        $imgUrl = ImageHelper::imageUrl('blogs_slider',$blogs['filename'])
    ?>
    <li title="<?=$title?>">
        <a href="<?=Yii::app()->createAbsoluteUrl('blogs/default/view', array('id'=>$blogs['id']))?>">
            <img style="width: 335px; height: 228px;" src="<?=$imgUrl?>" alt="<?=$title?>" title="<?=$title?>">
            <span>
                <span class="album-title"><?=$title?></span>
                <span class="album-date"><?=$blogs['firstname'].' '.$blogs['lastname'].' | '.$date?></span>
            </span>
        </a>
    </li>
<? } ?>
</ul>