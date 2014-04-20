<?php

// module/Logger/config/module.config.php:
return array(
	'listeners' => array(
		'LoggerListener'
	),
	'service_manager' => array(
		'aliases' => array(
			'LoggerListener' => 'LogEvents',
		),
	),
);
