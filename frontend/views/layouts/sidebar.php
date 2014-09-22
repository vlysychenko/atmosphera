<div class="sidebar">
        <?php
        $checkController = Yii::app()->controller->uniqueId;
        if($checkController === 'design/default'){
            $this->widget('application.widgets.CategoryWidget.CategoryForDesign');
        }else $this->widget('application.widgets.NewsOnMainWidget.NewsOnMain');
        ?>
</div>