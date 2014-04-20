<?php
// module/Logger/Module.php
namespace Logger;

use Zend\EventManager\EventInterface as Event;
use Zend\EventManager\EventsCapableInterface;
use Zend\Mvc\MvcEvent;
use Logger\Service\ErrorHandling as ErrorHandlingService;

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
	
	public function onBootstrap(Event $e)
	{
		$application = $e->getApplication();
		$services = $application->getServiceManager();
		$eventManager = $application->getEventManager();
		/**
		 * @note or otherwise
		 * $eventManager = $services->get('EventManager');
		 */
		$sharedEvents = $eventManager->getSharedManager();
		
		$logEvents = $services->get('LoggerListener');
		$sharedEvents->attach('*', $logEvents, null);
		
		$sharedEvents->attach('*', MvcEvent::EVENT_DISPATCH_ERROR, function($e){
			$exception = $e->getResult()->exception;
			if ($exception) {
				$sm = $e->getApplication()->getServiceManager();
				$errorHandler = $sm->get('Logger\Service\ErrorHandling');
				$errorHandler->logException($exception);
			}
		});
	}
	
	public function getControllerConfig()
	{
		return array(
			'initializers' => array(
				function ($instance, $sm) {
					if ($instance instanceof EventsCapableInterface) {
						$logEvents = $sm->getServiceLocator()->get('LogEvents');
						$logCallback = function ($e) use ($logEvents) {
							$event = $e->getName();
							if (substr($event, -4) == '.log') {
								$e->stopPropagation(true);
								$logEvents->log($e);
							}
						};
						$instance->getEventManager()->attach('*', $logCallback, 1000);
					}
				}
			)
		);
	}
	
	public function getServiceConfig()
	{
		return array(
			'invokables' => array(
				'logger-delegator-factory' => 'Logger\Service\LoggerDelegatorFactory',
			),
			'factories' => array(
				'LogEvents' => function ($sm) {
					$logger = $sm->get('Logger');
					$config  = $sm->get('Config');
					$configLog = $config['application']['log'];
					$di = new \Zend\Di\Di();
					return $di->get('Logger\Event\LogListener', array('logger' => $logger, 'config' => $configLog));
				},
				'Logger\Service\ErrorHandling' =>  function($sm) {
					$logger = $sm->get('Logger');
					$service = new ErrorHandlingService($logger);
					return $service;
				},
			),
			/**
			 * @todo Need?
			 */
//			'allow_override' => array(
//				'Logger' => true,
//			),
			'delegators' => array(
				'Logger' => array(
					'logger-delegator-factory',
					// eventually add more delegators here
				),
			),
		);
	}
}
