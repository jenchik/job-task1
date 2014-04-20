<?php

// module/Task1/src/Task1/Model/DepartmentTable.php:
namespace Task1\Model;

class DepartmentTable extends TableAbstract
{
	/**
	 * 
	 * @param int $id
	 * @return \Task1\Entity\Department
	 */
    public function getDepartment($id)
    {
		return $this->getById($id);
    }
}
