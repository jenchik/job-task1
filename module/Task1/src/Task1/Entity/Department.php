<?php

namespace Task1\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Department
 *
 * @ORM\Table(name="department", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Department
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name = '';

	/**
     *
	 * @ORM\OneToMany(targetEntity="Vacancy", mappedBy="id")
     */
	private $vacancies;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vacancies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Department
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add vacancies
     *
     * @param \Task1\Entity\Vacancy $vacancies
     * @return Department
     */
    public function addVacancy(\Task1\Entity\Vacancy $vacancies)
    {
        $this->vacancies[] = $vacancies;

        return $this;
    }

    /**
     * Remove vacancies
     *
     * @param \Task1\Entity\Vacancy $vacancies
     */
    public function removeVacancy(\Task1\Entity\Vacancy $vacancies)
    {
        $this->vacancies->removeElement($vacancies);
    }

    /**
     * Get vacancies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVacancies()
    {
        return $this->vacancies;
    }
	
	/**
     * Get vacancies for current result
	 * 
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getCurrentVacancies()
	{
		$criteria = Criteria::create();
		$criteria->where(Criteria::expr()->eq('idDepartment', $this->getId()));
		$id = $this->getId();
		return $this->getVacancies()->filter(function($item) use ($id) {
					return $item->getIdDepartment() === $id;
				});
	}
	
	/**
	 * Get vacancies by ID department
	 * 
	 * @param int $idDepartment
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getVacanciesByIdDepartment($idDepartment)
	{
		$criteria = Criteria::create();
		$criteria->where(Criteria::expr()->eq('idDepartment', $idDepartment));
		return $this->getVacancies()->matching($criteria);
	}
}
