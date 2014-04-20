<?php

// module/Task1/src/Task1/Model/VacancyTable.php:
namespace Task1\Model;

class VacancyTable extends TableAbstract
{
	/**
	 * 
	 * @param int $id
	 * @return \Task1\Entity\Vacancy
	 */
    public function getVacancy($id)
    {
        return $this->getById($id);
    }
}
