<div class="blogsitem" name = "item<?=$data['category_id']?>">
    <h2>
<!--        <a href="rubric.html">--><?//=$data->news->anounce?><!--</a>-->
        <a href="<?=yii::app()->createAbsoluteUrl('blogs/view/id/'.$data['post_id'])?>"><?=$data['p_title']?></a>
    </h2>
    <p><?=$data['anounce']. Yii::t('main', 'Category').' '. $data['name']?></p>
    <span class="small"><?= $data['firstname'].' '.$data['lastname']?> | <? $arr = explode(' ', $data['publication_date']);
        $timestamp = CDateTimeParser::parse($data['publication_date'], 'yyyy-MM-dd hh:mm:ss');
         echo $date = Yii::app()->dateFormatter->format('d MMMM y', $timestamp);?></span>
</div>
<?//}?>
