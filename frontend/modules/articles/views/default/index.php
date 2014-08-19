            <div id='ajaxUp' class="container">
                <div class="content">
                <? $this->widget('application.widgets.ArticleSlider.ArticleSliderWidget', array('sliderData' => $sliderData));?>
                    <div class="content-block">
                        <div class="title">Интересно</div>
                        <?php $this->widget('zii.widgets.CListView', array(
                            'dataProvider'=>$dataProvider,
                            'itemView'=>'articleitem', // представление для одной записи
                            'ajaxUpdate'=>true,
//                            'emptyText'=>'В данной категории нет товаров.',
//                            'summaryText'=>"{start}&mdash;{end} из {count}",
//                'template'=>'{summary} {sorter} {items} <hr> {pager}',
                            'template'=>'{items}{pager}',
//                            'sorterHeader'=>'Сортировать по:',
                            // ключи, которые были описаны $sort->attributes
                            // если не описывать $sort->attributes, можно использовать атрибуты модели
                            // настройки CSort перекрывают настройки sortableAttributes
//                'sortableAttributes'=>array('title', 'price'),
                            'pager'=>array(
                                'class'=>'application.widgets.GLinkPager',
                                'header'=>false,
//                                'cssFile'=>'/css/pager.css', // устанавливаем свой .css файл
                                'htmlOptions'=>array('class'=>'pagination'),
                            ),
                        )); ?>
                    </div>
                </div>
            </div>