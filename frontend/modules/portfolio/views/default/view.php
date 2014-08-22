<div class="container">
    <div class="content">
        <? if($portfolio){?>
        <div class="title"><?=$portfolio['title']?></div>
        <? } ?>
        <ul class="photo-list">
        <? foreach($photos as $photo){?>
            <? 
                //$arr = explode(' ', $article['publication_date']);
                //$timestamp = CDateTimeParser::parse($article['publication_date'], 'yyyy-MM-dd hh:mm:ss');
                //$date = Yii::app()->dateFormatter->format('d MMMM y', $timestamp);
                $description = ContentHelper::cutStringEx($photo['description'], 100);
                $imgThumbUrl = ImageHelper::imageUrl('portfolio_index_frontend', $photo['filename']);
                $imgRawUrl   = ImageHelper::imageUrl('raw', $photo['filename']);
            ?>
            <li>
                <a class="fancybox-button" rel="fancybox-button" href="<?=$imgRawUrl?>" title="<?=$description?>">
                    <img src="<?=$imgThumbUrl?>" alt="<?=$description?>" title="<?=$description?>">
                </a>
            </li>
        <? } ?>
        </ul>

        <h2><?=$portfolio['description']?></h2>
        <p><?=$portfolio['anounce']?></p>

        <?php $this->widget('application.extensions.fancybox.EFancyBox', array(
                    'target'=>'a[rel="fancybox-button"]',
                        'config'=>array(
                            'maxWidth'    => 1024,
                            'maxHeight'   => 980,
                            'fitToView'   => false,
                            'width'       => '70%',
                            'height'      => '70%',
                            'autoSize'    => false,
                            'closeClick'  => false,
                            'openEffect'  => 'elastic',
                            'closeEffect' => 'elastic',

                            'prevEffect'  => 'fade',
                            'nextEffect'  => 'fade',
                            //'closeBtn'    => false,
                            'helpers'     => array(
                                'title' => array(
                                    'type' => 'inside'
                                ),
                                'button' => array(),
                            ),
                        ),
        )); ?>

        <?php
             $this->widget('common.modules.comments.widgets.ECommentsListWidget', array(
                    'model' => $model,
                ));      
             /*$this->widget('common.modules.comments.widgets.ECommentsFormWidget', array(
                    'model' => $model,
                ));*/
         ?>

    </div>
</div>
