<?php

// module/Task1/src/Task1/Controller/TaskController.php:
namespace Task1\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Task1\Model\Task;
use Task1\Form\VacancyFilterForm;
use Config\ConfigAwareInterface;

class TaskController extends AbstractActionController implements ConfigAwareInterface
{
	protected $departmentTable;
	protected $vacancyTable;
	protected $lang;
	protected $logger;
	public $config;
	
	/**
	 * 
	 * @param \Zend\Log\Logger $logger
	 */
	public function __construct(\Zend\Log\Logger $logger)
	{
		$this->getEventManager()->trigger('log', $this, array(__FUNCTION__ . ' is starting...'));
		$this->logger = $logger;
	}
	
	/**
	 * 
	 * @param misc $config
	 */
	public function setConfig($config)
	{
		$this->config = $config;
	}
	
	public function indexAction()
	{
		$form = $this->getVacancyFilterForm();
		
		$request = $this->getRequest();
		/**
		 * @todo Also get parameter 'lang' from request URL
		 */
		if ($request->isPost()) {
			$form->setData($request->getPost());
			$this->setLocale($request->getPost()->get('lang'));
			$departmentId = $request->getPost()->get('department');
		}
		if ($departmentId) {
			/**
			 * For testing module Logger in custom debug mode
			 */
			$this->getEventManager()->trigger(__FUNCTION__, $this, compact('departmentId'));
			$vacancies = $this->getDepartmentTable()
					->getDepartment($departmentId)->getCurrentVacancies();
		} else {
			$vacancies = $this->getVacancyTable()->fetchAll();
		}
		
		return new ViewModel(array(
				'vacancies' => $vacancies,
				'form' => $form,
				'lang' => $this->getLocale(),
			));
	}
	
	/**
	 * 
	 * @return \Task1\Model\VacancyTable
	 */
    public function getVacancyTable()
    {
        if (!$this->vacancyTable) {
            $this->vacancyTable = $this->getServiceLocator()
					->get('Task1\Model\VacancyTable');
        }
        return $this->vacancyTable;
    }
	
	/**
	 * 
	 * @return \Task1\Model\DepartmentTable
	 */
    public function getDepartmentTable()
    {
        if (!$this->departmentTable) {
            $this->departmentTable = $this->getServiceLocator()
					->get('Task1\Model\DepartmentTable');
        }
        return $this->departmentTable;
    }
	
	/**
	 * 
	 * @return \Task1\Form\VacancyFilterForm
	 */
	public function getVacancyFilterForm()
	{
		$departments = array(0 => '');
		foreach ($this->getDepartmentTable()->fetchAll() as $department) {
			$departments[$department->getId()] = $department->getName();
		}
		return new VacancyFilterForm(null, array(
						'departments' => $departments,
				));
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getLocale()
	{
		if (!$this->lang) {
			$this->setLocale();
		}
		
		return $this->lang;
	}
	
	/**
	 * 
	 * @param string $lang
	 */
	public function setLocale($lang = null)
	{
		$sm = $this->getServiceLocator();
		$translator = $sm->get('MvcTranslator');
		if ($lang) {
			$translator->setLocale($lang);
		}
		$this->lang = $translator->getLocale();
	}
}