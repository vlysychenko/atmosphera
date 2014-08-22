<div>
    <ul>
        <li>
            <a href="<?=yii::app()->createAbsoluteUrl('/')?>">Главная</a>
        </li>
        <li>
            <a href="<?=yii::app()->createUrl('about')?>"><?=Yii::t('main', 'about us')?></a>
        </li>
        <li>
            <a href="<?=yii::app()->createUrl('blogs')?>"><?=Yii::t('main', 'blogs')?></a>
        </li>
        <li>
            <a href="<?=yii::app()->createUrl('contacts')?>"><?=Yii::t('main', 'contacts')?></a>
        </li>
        <li>
            <a href="<?=yii::app()->createUrl('gallery')?>"><?=Yii::t('main', 'gallery')?></a>
        </li>
        <li>
            <a href="<?=yii::app()->createUrl('partners')?>"><?=Yii::t('main', 'partners')?></a>
        </li>
        <li>
            <a href="<?=yii::app()->createUrl('search')?>"><?=Yii::t('main', 'search')?></a>
        </li>
        <li>
            <a href="<?=yii::app()->createUrl('horoscope')?>"><?=Yii::t('main', 'horoscope')?></a>
        </li>
    </ul>
</div>