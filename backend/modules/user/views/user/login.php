<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>
<div class="container">
    <div class="login">
    <h1><?=Yii::t('main','Login to Top Granat')?></h1>
    <?php echo CHtml::beginForm(Yii::app()->getModule('user')->loginUrl,'post',array('class'=>'clearfix')); ?>
    <p><?php echo CHtml::activeTextField($model,'email',array('size'=>30,'placeholder'=>Yii::t('main','E-mail'))) ?></p>
        <? echo CHtml::error($model,'email');?>
    <p><?php echo CHtml::activePasswordField($model,'password',array('size'=>30,'placeholder'=>Yii::t('main','Password'))) ?></p>
        <?
        echo CHtml::error($model,'password');
        echo CHtml::error($model,'status');
        ?>
    <div class="login-help">
        <p><?=Yii::t('main','Forgot your password?')?> <?php echo CHtml::link(Yii::t('main',"Restore"),Yii::app()->getModule('user')->recoveryUrl,array('class'=>'fz-10')); ?>.</p>
    </div>
    <p class="submit"><?php echo CHtml::submitButton(Yii::t('main',"Submit")); ?></p>

    </div>
    </div>

<?php echo CHtml::endForm(); ?>