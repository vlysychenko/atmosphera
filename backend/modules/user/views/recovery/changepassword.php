<div class="container">
    <div class="login">
        <h1><?php echo Yii::t('main',"Change Password"); ?></h1>
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::errorSummary($form); ?>
        <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
        </p>
        <p><?php echo CHtml::activePasswordField($form,'password',array('placeholder'=>Yii::t('main','Password'))); ?></p>
        <p>
            <?php echo CHtml::activePasswordField($form,'verifyPassword',array('placeholder'=>Yii::t('main','Verify password'))); ?>
        </p>
        <p class="submit"><?php echo CHtml::submitButton(UserModule::t("Save")); ?></p>

    </div>
</div>


<?php echo CHtml::endForm(); ?>
