<?php

// module/Logger/src/Logger/Event/LogListener.php:
namespace Logger\Event;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Log\Logger;

class LogListener implements ListenerAggregateInterface
{
	protected $listeners = array();
	protected $logger;
	protected $config;
	
	/**
	 * 
	 * @param \Zend\Log\Logger $logger
	 * @param misc $config
	 */
	public function __construct(Logger $logger, $config = array())
	{
		$this->logger = $logger;
		$this->config = $config;
	}
	
	/**
	 * 
	 * @param \Zend\EventManager\EventManagerInterface $events
	 */
	public function attach(EventManagerInterface $events)
	{
		$this->listeners[] = $events->attach(array('log','logger','logging'), array($this, 'log'));
	}
	
	/**
	 * 
	 * @param \Zend\EventManager\EventManagerInterface $events
	 */
	public function detach(EventManagerInterface $events)
	{
		foreach ($this->listeners as $index => $listener) {
			if ($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}
	
	/**
	 * 
	 * @param \Zend\EventManager\EventInterface $e
	 */
	public function log(EventInterface $e)
	{
		$event = $e->getName();
		$target = get_class($e->getTarget());
		$params = $e->getParams();
		if (is_array($params) && isset($params['debug'])) {
			$isDebug = $params['debug'];
			unset($params['debug']);
		} else {
			$isDebug = (isset($this->config['debug'])) ? $this->config['debug'] : false;
		}
		if ($isDebug) {
			$text =	sprintf(
				'Handled event "%s" on target "%s", with parameters %s',
				$event,
				$target,
				json_encode($params)
			);
			$this->logger->debug($text);
		} else {
			$params = array_values($params);
//			$text = $params[0];
			$text = implode(';', $params);
			$this->logger->info($text);
		}
	}
}
