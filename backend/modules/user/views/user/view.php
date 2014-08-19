<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('index'),
	$model->user_id,
);
?>
<h1><?php echo UserModule::t('View User').' "'.$model->firstname. ' '.  $model->lastname. '"'; ?></h1>

<ul class="actions">
	<li><?php echo CHtml::link(UserModule::t('List User'),array('index')); ?></li>
</ul><!-- actions -->

<?php 

// For all users
	$attributes = array(
	);
	
	$profileFields=ProfileField::model()->forAll()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => UserModule::t($field->title),
					'name' => $field->varname,
					'value' => $model->profile->getAttribute($field->varname),
				));
		}
	}
	array_push($attributes,
        array(
            'name' => 'email',
            'value' => (($model->email)),
        ),        
        array(    
			'name' => 'createtime',
			'value' => date("d.m.Y H:i:s",$model->createtime),
		),
		array(
			'name' => 'lastvisit',
			'value' => (($model->lastvisit)?date("d.m.Y H:i:s",$model->lastvisit):UserModule::t('Not visited')),
		)
	);
			
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));

?>
