<div class="container">
    <div class="content">
        <div class="title"><?=Yii::t('main', 'Interestingly')?></div>
        
        <?php if ($data !== false) {?>
            <h2><?=$data['title']?></h2>
            <span class="small"><?=$data['lastname'].' '.$data['firstname'].' '?> |  <? $arr = explode(' ', $data['publication_date']);
                $timestamp = CDateTimeParser::parse($data['publication_date'], 'yyyy-MM-dd hh:mm:ss');
                echo $date = Yii::app()->dateFormatter->format('d MMMM y', $timestamp);?> </span>
            <div class="rubric">
                 <?=$data['content']?>
            </div>
            
            <?php if($data['is_active']) { ?>
            
                <ul class="photo-list">
                <?php foreach($photos as $photo){?>
                    <?php 
                        $description = ContentHelper::cutStringEx($photo['description'], 100);
                        $imgThumbUrl = ImageHelper::imageUrl('gallery_index_frontend', $photo['filename']);
                        $imgRawUrl   = ImageHelper::imageUrl('raw', $photo['filename']);
                    ?>
                    <li>
                        <a class="fancybox-button" rel="fancybox-button" href="<?=$imgRawUrl?>" title="<?=$description?>">
                            <img src="<?=$imgThumbUrl?>" alt="<?=$description?>" title="<?=$description?>">
                        </a>
                    </li>
                <? } ?>
                </ul>

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

            <?php } ?>

        <?php } ?>
        
        <?php
             $this->widget('common.modules.comments.widgets.ECommentsListWidget', array(
                    'model' => $model,
                ));
         ?>
        
    </div>
</div>
