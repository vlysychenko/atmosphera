<?php
/**
 *
 * main.php configuration file
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
return array(
	'preload' => array('log'),
    'language' => 'ru',
	'aliases' => array(
		'frontend' => dirname(__FILE__) . '/../..' . '/frontend',
		'common' => dirname(__FILE__) . '/../..' . '/common',
		'backend' => dirname(__FILE__) . '/../..' . '/backend',
		'vendor' => 'common.lib.vendor'
	),
	'import' => array(
		'common.extensions.components.*',
		'common.components.*',
		'common.helpers.*',
		'common.models.*',
		'application.controllers.*',
		'application.extensions.*',
		'application.helpers.*',
		'application.models.*',
		'vendor.2amigos.yiistrap.helpers.*',
		'vendor.2amigos.yiiwheels.helpers.*',
	),
	'components' => array(
		'db'=>array(
            'connectionString' => 'mysql:host=localhost;port=3307;dbname=atmosphera',
            'username' => 'root',
            'password' => '',
            'enableProfiling' => false,
            'enableParamLogging' => false,
            'charset' => 'utf8',
            'tablePrefix' => '',
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'log' => array(
			'class'  => 'CLogRouter',
			'routes' => array(
				array(
					'class'        => 'CDbLogRoute',
					'connectionID' => 'db',
					'levels'       => 'error, warning',
				),
			),
		),

        //UserModule
        'user'=>array(
            // enable cookie-based authentication
//            'class' => 'backend.modules.user.models.User',
            'class' => 'system.web.auth.CWebUser',
//            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),
    ),

    // common application modules
    'modules' => array(
        'comments'=>array(
            'class' => 'common.modules.comments.CommentsModule',
            //you may override default config for all connecting models
            'defaultModelConfig' => array(
                //only registered users can post comments
                'registeredOnly' => false,
                'useCaptcha' => false,
                //allow comment tree
                'allowSubcommenting' => true,
                //display comments after moderation
                'premoderate' => false,
                //action for postig comment
                'postCommentAction' => 'comments/comment/postComment',
                //super user condition(display comment list in admin view and automoderate comments)
                'isSuperuser'=>'Yii::app()->user->checkAccess("moderate")',
                //order direction for comments
                'orderComments'=>'DESC',
            ),
            //the models for commenting
            'commentableModels'=>array(
                //model with individual settings
                /*'News'=>array(
                    'registeredOnly'=>false,
                    'useCaptcha'=>false,
                    'allowSubcommenting'=>true,
                    //config for create link to view model page(page with comments)
                    'pageUrl'=>array(
                        'route'=>'news/default/view',
                        'data'=>array('id'=>'post_id'),
                    ),
                ),*/
                //model with default settings
                'News',
                'GalleryPosts',
            ),
            //config for user models, which is used in application
            'userConfig'=>array(
                'class'=>'User',
                'nameProperty'=>'username',
                'emailProperty'=>'email',
            ),
        ),
    ),
    
    
	'params' => array(
		// php configuration
		'php.defaultCharset' => 'utf-8',
		'php.timezone'       => 'Europe/Athens', //'UTC',
        'partner_id'         => 18,
	)
);
