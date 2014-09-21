<ul class="category">
    <?php
    if($listCategories){
        foreach($listCategories as $key => $val){
            echo '<li>'. CHtml::link($val, Yii::app()->createAbsoluteUrl('/design/'.$key)).'</li>';
        }
    }
    ?>
</ul>