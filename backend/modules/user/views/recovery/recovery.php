<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="container">
    <div class="login">
        <h1><?=Yii::t('main','Restore password')?></h1>
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
    </div>
    </div>
<?php else: ?>
    <div class="container">
        <div class="login">
            <h1><?=Yii::t('main','Restore password')?></h1>
            <?php echo CHtml::beginForm(Yii::app()->getModule('user')->recoveryUrl,'post',array('class'=>'clearfix')); ?>
            <?php echo CHtml::errorSummary($form); ?>
            <p><?php echo CHtml::activeTextField($form,'login_or_email',array('size'=>20,'placeholder'=>'E-mail')) ?></p>

            <p class="submit"><?php echo CHtml::submitButton(Yii::t('main',"Restore"),array('value'=>Yii::t('main',"Restore"))); ?></p>

        </div>
    </div>
<?php echo CHtml::endForm(); ?>

<?php endif; ?>