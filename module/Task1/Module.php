<?php
// module/Task1/Module.php
namespace Task1;

use Task1\Model\DepartmentTable;
use Task1\Model\VacancyTable;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Task1\Model\DepartmentTable' =>  function($sm) {
					$em = $sm->get('doctrine.entitymanager.orm_default');
					$table = $em->getRepository('Task1\Entity\Department');
                    return new DepartmentTable($table);
                },
                'Task1\Model\VacancyTable' =>  function($sm) {
					$em = $sm->get('doctrine.entitymanager.orm_default');
					$table = $em->getRepository('Task1\Entity\Vacancy');
                    return new VacancyTable($table);
                },
				'Task1:Logger' => function ($sm) {
					$logger = $sm->get('Logger');
					$logger = clone $logger;
					$path = $sm->get('LoggerPath');
					$writer = new \Zend\Log\Writer\Stream($path . 'task1.log');
					$logger->addWriter($writer);
					return $logger;
				},
            ),
		);
    }
}