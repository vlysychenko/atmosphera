<?php
/**
 *
 * frontend.php configuration file
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
defined('APP_CONFIG_NAME') or define('APP_CONFIG_NAME', 'frontend');

// web application configuration
return array(
	'name' => '{APPLICATION NAME}',
	'basePath' => realPath(__DIR__ . '/..'),
	// path aliases
	'aliases' => array(
		'bootstrap' => dirname(__FILE__) . '/../..' . '/common/lib/vendor/2amigos/yiistrap',
		'yiiwheels' => dirname(__FILE__) . '/../..' . '/common/lib/vendor/2amigos/yiiwheels',
        'comments'  => dirname(__FILE__) . '/../..' . '/common/modules/comments',
	),

	// application behaviors
	'behaviors' => array(),

	// controllers mappings
	'controllerMap' => array(),

    'import' => array(
        'frontend.extensions.fancybox.*',
        'frontend.extensions.bxslider.*',
        'frontend.widgets.SearchWidget.*',
        'frontend.components.*',
        'backend.modules.user.models.*',
    ),

	// application modules
	'modules' => array(
        'about' => array(
//            'class' => 'frontend.modules.about.AboutModule',
        ),
        'blogs' => array(
            'class' => 'frontend.modules.blogs.BlogsModule',
        ),
        'contacts' => array(
//            'class' => 'frontend.modules.contacts.ContactsModule',
        ),
        'gallery' => array(
//            'class' => 'frontend.modules.gallery.GalleryModule',
        ),
        'partners' => array(
//            'class' => 'frontend.modules.partners.PartnersModule',
        ), 
        'search' => array(
            'class' => 'frontend.modules.search.SearchModule',
        ),
        'horoscope',

        /*'comments'=>array(
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
                'News'=>array(
                    'registeredOnly'=>false,
                    'useCaptcha'=>true,
                    'allowSubcommenting'=>true,
                    //config for create link to view model page(page with comments)
                    'pageUrl'=>array(
                        'route'=>'news/default/view',
                        'data'=>array('id'=>'post_id'),
                    ),
                ),
                //model with default settings
                //'ImpressionSet',
            ),
            //config for user models, which is used in application
            'userConfig'=>array(
                'class'=>'User',
                'nameProperty'=>'username',
                'emailProperty'=>'email',
            ),
        ),*/

        'sitemap',
    ),
    
	// application components
	'components' => array(
		'bootstrap' => array(
			'class' => 'bootstrap.components.TbApi',
		),
        'messages'=>array(
            'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../common'.DIRECTORY_SEPARATOR.'messages',
        ),
		'clientScript' => array(
			'scriptMap' => array(
				'bootstrap.min.css' => false,
				'bootstrap.min.js' => false,
				'bootstrap-yii.css' => false
			)
		),
		'urlManager' => array(
			// uncomment the following if you have enabled Apache's Rewrite module.
			'urlFormat' => 'path',
			'showScriptName' => false,

			'rules' => array(
				// default rules
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'blogs/view/id/<id:\d+>'=>'blogs/default/view/id/<id>',
                'blogs/default/index/page/<id\w+>'=>'blogs/default/index/page/<id>',
                'blogs'=>'blogs/default/index/',
                'sitemap.xml'=>'sitemap/default/indexxml',
			),
		),
		'user' => array(
			'allowAutoLogin' => true,
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		)
	),
);