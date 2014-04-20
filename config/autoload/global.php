<?php

// config/autoload/global.php:
return array(
	'application' => array(
	'log' => array(
		'path' => 'logs/',
		'debug' => false,
	),
	),
	'db' => array(
		'driver'         => 'Pdo',
		'dsn'            => 'mysql:dbname=job-task1;host=localhost',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
	),
	'service_manager' => array(
		'factories' => array(
			'Zend\Db\Adapter\Adapter'
					=> 'Zend\Db\Adapter\AdapterServiceFactory',
		),
	),
);