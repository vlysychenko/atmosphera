<?php
    $month =  mb_strtolower(Magazine::getMonthName($data['publication_month']), 'UTF-8');
    $year = $data['publication_year'];
    $imgUrl = ImageHelper::imageUrl('magazine_title',$data['filename']);
    if(isset($data['magazine']) && !empty($data['magazine']) && file_exists(Yii::app()->params['uploadDir'].$data['magazine'])){
        $magazine = $data['magazine'];
    }else{
        $magazine = false;
    }
    echo "<img alt='".$data['title']."' title='".$data['title']."' src='".$imgUrl."'>";
?>
        <p>журнал «Atmosphera»<br><?="$month, $year г."?></p>
        <a class="button" target="helperFrame" href="<?php if($magazine) echo Yii::app()->createAbsoluteUrl('blogs/default/downloadFile',array('filename'=>$magazine)) ; else echo '#';?>">скачать</a>
        <iframe style="display: none;" name="helperFrame"></iframe>