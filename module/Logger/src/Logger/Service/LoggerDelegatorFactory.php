<?php

// module/Logger/src/Logger/Service/LoggerDelegatorFactory.php:
namespace Logger\Service;

use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoggerDelegatorFactory implements DelegatorFactoryInterface
{
	/**
	 * 
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
	 * @param string $name
	 * @param string $requestedName
	 * @param callable $callback
	 * @return object
	 */
	public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
	{
		$defaultLogger = call_user_func($callback);
		$path = $serviceLocator->get('LoggerPath');
		$writer = new \Zend\Log\Writer\Stream($path . 'logger.log');
		$defaultLogger->addWriter($writer);
		return $defaultLogger;
	}
}
