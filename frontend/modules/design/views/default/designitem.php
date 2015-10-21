<div>
    <h2>
        <a href="<?=yii::app()->createAbsoluteUrl('design/view/id/'.$data['post_id'])?>"><?=$data['p_title']?></a>
    </h2>
    <?php echo CHtml::image(ImageHelper::imageUrl('', $data['filename']), 'image'); ?>
    <p><?=$data['anounce']?></p>
    <span class="small"><?= $data['firstname'].' '.$data['lastname']?> | <?php $arr = explode(' ', $data['publication_date']);
        $timestamp = CDateTimeParser::parse($data['publication_date'], 'yyyy-MM-dd hh:mm:ss');
        echo $date = Yii::app()->dateFormatter->format('d MMMM y', $timestamp);?>
    </span>
</div>
<?//}?>
