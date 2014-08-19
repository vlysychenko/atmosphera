<?php
if(YII_DEBUG)
    echo CHtml::encode( $message ); 
else{
?>
<div class="container">
    <div class="content">
        <center>
            <p><strong style="font-size:30px;">Ошибка - 404</strong></p>
            <p>Уважаемый посетитель сайта!</p>
            <p>Запрашиваемая вами страница не существует либо произошла ошибка.</p>
            <p>Если вы уверены в правильности указанного адреса, то данная страница уже не существует на сервере или была переименована.</p>
        </center>
    </div>
</div>
<?
}
 ?>
