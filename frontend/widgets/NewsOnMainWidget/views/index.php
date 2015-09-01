<div class="container">
    <div class="title-for-main-news">
        <?php echo Yii::t('main', 'INTERESTING FROM THE BLOG').':'?>
    </div>
    <div class="image">
        <?php echo isset($photoNewsMain) ? CHtml::image(Yii::app()->createAbsoluteUrl('/upload/'.$photoNewsMain), 'image') : '' ?>
    </div>
    <div class="content for-main-news">
        <?php echo isset($newsMain) ? CHtml::link($newsMain->content, Yii::app()->createAbsoluteUrl('/blogs/view/id/'.$newsMain->post_id)) : ''?>
    </div>
</div>
