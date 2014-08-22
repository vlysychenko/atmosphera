<?php
/**
 *
 * console.php configuration file
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
defined('APP_CONFIG_NAME') or define('APP_CONFIG_NAME', 'console');

return array(
	'basePath' => realPath(__DIR__ . '/..'),

    'aliases' => array(
        'backend' => dirname(__FILE__) . '/../..' . '/backend',
    ),

	'commandMap' => array(
		'migrate' => array(
			'class' => 'system.cli.commands.MigrateCommand',
			'migrationPath' => 'application.migrations'
		),
        'message' => array(
            'class' => 'system.cli.commands.MessageCommand',
        )
	),
    
    'import' => array(
        'backend.modules.portfolio.models.*',
    ),
);