<?php
return array(
	'modules' => array(
		'Application',
		'DoctrineModule',
		'DoctrineORMModule',
		'Task1',
		'Logger',
	),
	'module_listener_options' => array(
		'config_glob_paths'    => array(
			'config/autoload/{,*.}{global,local}.php',
		),
		'module_paths' => array(
			'./module',
			'./vendor',
		),
	),
);
