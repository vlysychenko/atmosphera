<?php
$banerScript = '';
$i = 0;
foreach($data as $rowdata){
    if($rowdata['mime_type'] == 'image/jpeg'){
        echo '<a href="'.$rowdata['link'].'" target="_blank"><img src="'.ImageHelper::imageUrl('banners_photo',$rowdata['filename']).'" alt="'.$rowdata['title'].'"/></a>'; // todo:file path
    }else{$i++;?>
      <div id="banner<?=$i?>">
        <p>Banner</p>
      </div>
      <?
        $banerScript .= 'swfobject.embedSWF("'.Yii::app()->params['uploadUrl'].'files/'.$rowdata['filename'].'", "banner'.$i.'", "272", "191", "9.0.0", false, {}, {wmode: "transparent"});'
      ?>
<? }
    Yii::app()->clientScript->registerScript('bannerScript',$banerScript,CClientScript::POS_BEGIN);
}?>