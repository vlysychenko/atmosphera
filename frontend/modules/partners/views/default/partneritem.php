<div class="partner">
    <img src="<?=$imgUrl = ImageHelper::imageUrl('partner_index_frontend',$this->getIndexFotoFile($data['gallery_id']))?>" alt=""/>
    <div>
        <h3><?=$data['title']?></h3>
        <?=$data['description']?>
        <div class="small">
         <?=$data['contacts']?>
        </div>
    </div>
</div>