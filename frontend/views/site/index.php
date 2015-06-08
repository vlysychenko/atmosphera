<div class="container">
    <!--<div class="content"><img src="<?php echo $image ?>" alt="image" width="750" height="1000"/></div>-->
    <div class="content"><img src="<?php echo $image ?>" alt="image" /></div>
<!--    <div class="content">-->
<!--        <div class="slider">-->
<!--            --><?//
//            $this->widget(
//                'frontend.extensions.bxslider.BxSlider',
//                array(
//                    'slides' => $slides,
//                    'id' => 'main-portfolio-slider',
//                    'htmlOptions' => array(),
//                    'sliderOptions' => array(
//                        'pager' => false,
//                        'slideWidth' => 680,
//                        'minSlides' => 1,
//                        'maxSlides' => 1,
//                        'auto' => true,
//                        'autoControls' => false,
//                        'infiniteLoop' => true,
//                        'slideMargin' => 20,
//                    ),
//                    'sliderHtmlOptions' => array(),
//                )
//            );
//            ?>
<!--        </div>-->
<!---->
<!--        --><?//foreach ($newsData as $data) {
//            $arr = explode(' ', $data['publication_date']);
//            $date = Yii::app()->dateFormatter->formatDateTime(
//                CDateTimeParser::parse($arr[0], 'yyyy-MM-dd'),
//                'long',
//                null
//            );
//            ?>
<!--            <div class="content-block">-->
<!--                <div class="title">Интересно</div>-->
<!--                <a href="--><?//= Yii::app()->createAbsoluteUrl('blogs/view/id/' . $data['post_id']) ?><!--">-->
<!--                    <img src="--><?//= ImageHelper::imageUrl('blogs_isTop_frontend', $data['photo']['filename']) ?><!--"-->
<!--                         alt="--><?//= ContentHelper::prepareStr($data['photo']['description']) ?><!--"-->
<!--                         title="--><?//= ContentHelper::prepareStr($data['photo']['description']) ?><!--"/>-->
<!--                </a>-->
<!---->
<!--                <div>-->
<!--                    <h2><a href="--><?//= Yii::app()->createAbsoluteUrl(
//                            'blogs/view/id/' . $data['post_id']
//                        ) ?><!--">--><?//= $data['p_title'] ?><!--</a></h2>-->
<!--                    --><?//= $data['anounce'] ?>
<!--                    <span class="small">--><?//= $data['firstname'] . ' ' . $data['lastname'] . ' | ' . $date ?><!--</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?// } ?>
<!--    </div>-->
</div>
