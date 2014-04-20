<?php

namespace Application\Service;
 
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class CommonModelTableAbstractFactory implements AbstractFactoryInterface
{
	/**
	 * 
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $locator
	 * @param string $name
	 * @param string $requestedName
	 * @return bool
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
	{
		return (substr($requestedName, -5) === 'Table');
	}
	
	/**
	 * 
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $locator
	 * @param string $name
	 * @param string $requestedName
	 * @return object
	 */
	public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
	{
		$db = $locator->get('Zend\Db\Adapter\Adapter');
		$tablemodel = new $requestedName;
		$tablemodel->setDbAdapter($db);
		return $tablemodel;
	}
}
