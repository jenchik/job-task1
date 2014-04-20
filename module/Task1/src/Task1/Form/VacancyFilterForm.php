<?php

// module/Task1/src/Task1/Form/VacancyFilterForm.php:
namespace Task1\Form;

use Zend\Form\Form;

class VacancyFilterForm extends Form
{
	protected $_departments = array();
	
	public function __construct($name = null, $options = array())
    {
		if (isset($options['departments'])) {
			$this->setDepartments($options['departments']);
			unset($options['departments']);
		}
        parent::__construct('vacancy', $options);
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'lang',
			'type' => 'select',
            'options' => array(
                'label' => 'Language',
				'value_options' => array(
                             '' => '',
                             'en_US' => 'English',
                             'ru_RU' => 'Russian',
                     ),
            ),
        ));
        $this->add(array(
            'name' => 'department',
			'type'  => 'select',
            'options' => array(
                'label' => 'Department',
				'value_options' => $this->_departments,
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Filter',
                'id' => 'submitbutton',
            ),
        ));
    }
	
	public function setDepartments(array $departments)
	{
		$this->_departments = $departments;
	}
}