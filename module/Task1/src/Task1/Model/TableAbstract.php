<?php

// module/Task1/src/Task1/Model/TableAbstract.php:
namespace Task1\Model;

abstract class TableAbstract
{
	/** @var \Doctrine\ORM\EntityRepository */
    protected $entity;
	
	/**
	 * 
	 * @param \Doctrine\ORM\EntityRepository $entity
	 */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }
	
	/**
	 * 
	 * @param string $name
	 * @param array $arguments
	 * @return misc
	 */
	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->entity, $name), $arguments);;
	}
	
	/**
	 * 
	 * @return array The objects.
	 */
	public function fetchAll()
    {
		return $this->entity->findAll();
    }
	
	/**
	 * 
	 * @param int $id
	 * @return object The entity instance.
	 * @throws \Exception
	 */
    public function getById($id)
    {
        $id  = (int) $id;
        $row = $this->entity->findOneBy(array('id' => $id));
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
}
