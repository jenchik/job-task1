<?php

// module/Task1/config/module.config.php:
return array(
    'controllers' => array(
        'factories' => array(
			'Task1\Controller\Task' => 'Task1\ControllerFactory\TaskControllerFact',
		),
    ),
    'router' => array(
        'routes' => array(
            'task1' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/task1[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Task1\Controller\Task',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'task1' => __DIR__ . '/../view',
        ),
    ),
	'doctrine' => array(
		'driver' => array(
			'Task1_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/Task1/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					'Task1\Entity' =>  'Task1_driver'
				),
			),
		),
	),
);
