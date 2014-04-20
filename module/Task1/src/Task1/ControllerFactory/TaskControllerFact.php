<?php

namespace Task1\ControllerFactory;
use \Zend\ServiceManager\FactoryInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;
use \Task1\Controller\TaskController;

class TaskControllerFact implements FactoryInterface
{
	/**
	 * 
	 * @param \Zend\Mvc\Controller\ControllerManager $serviceLocator
	 * @return \Task1\Controller\TaskController
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
		$sm   = $serviceLocator->getServiceLocator();
		$logger = $sm->get('Task1:Logger');
		
		$controller = new TaskController($logger);
		$sharedEvents = $controller->getEventManager()->getSharedManager();
		$sharedEvents->attach(get_class($controller), array('indexAction'),
			function ($e) use ($controller) {
				$event = $e->getName();
				$target = get_class($e->getTarget());
				$params = $e->getParams();
				$message = sprintf(
						'[%s] [%s] Cached datas: %s',
						$event,
						$target,
						json_encode($params)
					);
				$controller->getEventManager()->trigger($event . '.log', $e->getTarget(), array('message' => $message, 'debug' => true));
			});
		return $controller;
	}
}
