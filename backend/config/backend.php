<?php
/**
 *
 * backend.php configuration file
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
defined('APP_CONFIG_NAME') or define('APP_CONFIG_NAME', 'backend');

// web application configuration
return array(
	'name' => '{APPLICATION NAME}',
	'basePath' => realPath(__DIR__ . '/..'),
	// path aliases
	'aliases' => array(
		'bootstrap' => dirname(__FILE__) . '/../..' . '/common/lib/vendor/2amigos/yiistrap',
		'yiiwheels' =>  dirname(__FILE__) . '/../..' . '/common/lib/vendor/2amigos/yiiwheels'
	),

    // application behaviors
    'behaviors' => array(
        //'deletable' => array(
        //    'class' => 'common.extensions.behaviors.DeletableBehavior',
        //),
    ),

    'import' => array(
        'yiiwheels.widgets.fineuploader.*',
        'application.widgets.PhotoPortfolio.*', 
        //'application.extensions.deletable-behavior.DeletableBehavior', 
        'common.extensions.behaviors.*',   //it's very good for auto import for new behaviors
        'application.components.*',
        'application.modules.portfolio.models.*',
        'application.models.*',
        'backend.modules.user.models.*',
    ),

	// controllers mappings
	'controllerMap' => array(),

	// application modules
	'modules' => array(
        'user'=>array(
            'class' => 'backend.modules.user.UserModule',
            # encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => true,
            # allow access for non-activated users
            'loginNotActiv' => false,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
            # automatically login from registration
            'autoLogin' => true,
            # registration path
            'registrationUrl' => array('/user/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            'loginUrl' => '/user/login', //array('/user/login'),
            # page after login
            'returnUrl' => array('/user/profile'),
            # page after logout
            'returnLogoutUrl' => '/user/login', //array('/user/login'),
            'adminUrl'=>'user/admin',
            //module tables
            'tableUsers' => 'user',
            'tableProfiles' => 'profiles',
            'tableProfileFields' => 'profiles_fields',
        ),
        'portfolio' => array(
            'class' => 'backend.modules.portfolio.PortfolioModule',
        ),
        'magazine' => array(
            'class' => 'backend.modules.magazine.MagazineModule',
        ),
        'news' => array(
            'class' => 'backend.modules.news.NewsModule',
        ),
        'tag' => array(
            'class' => 'backend.modules.tag.TagModule',
        ),
        'portfolioposts' => array(
            'class' => 'backend.modules.portfolioposts.PortfolioPostsModule',
        ),
        'partners' => array(
            'class' => 'backend.modules.partners.PartnersModule',
        ),
        'banners' => array(
            'class' => 'backend.modules.banners.BannersModule',
        ),
        'horoscope' => array(
            'class' => 'backend.modules.horoscope.HoroscopeModule',
        ),
        'contacts'=> array(
            'class' =>'backend.modules.contacts.ContactsModule',
        ),
        'about' => array(
            'class' => 'backend.modules.about.AboutModule',
        ),
        'mainpage' => array(
            'class' =>  'backend.modules.mainpage.MainpageModule'
        ),
        'design' => array(
            'class' =>  'backend.modules.design.DesignModule'
        ),
        'category' => array(
            'class' =>  'backend.modules.category.CategoryModule'
        ),
    ),

	// application components
	'components' => array(

		'bootstrap' => array(
			'class' => 'bootstrap.components.TbApi',
		),

        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
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
			),
		),
		'user' => array(
//			'allowAutoLogin' => true,
            'authTimeout' => 86400, //24 hours
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		)
	),
);