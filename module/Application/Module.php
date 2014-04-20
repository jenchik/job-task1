<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Log\Writer\Stream;
use Config\ConfigAwareInterface;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$e->getApplication()->getServiceManager()->get('translator');
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
	
	public function getControllerConfig()
	{
		return array(
			'initializers' => array(
				function ($instance, $sm) {
					if ($instance instanceof ConfigAwareInterface) {
						$locator = $sm->getServiceLocator();
						$config  = $locator->get('Config');
						$instance->setConfig($config['application']);
					}
				}
			)
		);
	}
	
	public function getServiceConfig()
	{
		return array(
			'invokables' => array(
				'Zend\Log\Logger' => 'Zend\Log\Logger',
			),
			'factories' => array(
				'LoggerPath' => function ($sm) {
					$config  = $sm->get('Config');
					$config = $config['application'];
					return (isset($config['log']['path'])) ? $config['log']['path'] : 'logs/';
				},
				'Logger' => function ($sm) {
					$path = $sm->get('LoggerPath');
					$writer = new Stream($path . 'main.log');
					$logger = $sm->get('Zend\Log\Logger');
					$logger->addWriter($writer);
					return $logger;
				},
			),
			'initializers' => array(
				function ($instance, $sm) {
					if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
						$instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
					}
				}
			),
			'abstract_factories' => array(
				'Application\Service\CommonModelTableAbstractFactory',
			),
		);
	}
}
