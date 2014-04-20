<?php

namespace Task1\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Vacancy
 *
 * @ORM\Table(name="vacancy", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="id_department", columns={"id_department"})})
 * @ORM\Entity
 */
class Vacancy
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
     * @var integer
     *
     * @ORM\Column(name="id_department", type="bigint", nullable=true)
     */
    private $idDepartment;

	/**
     *
	 * @ORM\ManyToOne(targetEntity="Department")
	 * @ORM\JoinColumn(name="id_department", referencedColumnName="id")
     */
    private $department;

	/**
     *
	 * @ORM\OneToMany(targetEntity="VacancyTrans", mappedBy="idVacancy")
     */
    private $translates;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translates = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set idDepartment
     *
     * @param integer $idDepartment
     * @return Vacancy
     */
    public function setIdDepartment($idDepartment)
    {
        $this->idDepartment = $idDepartment;

        return $this;
    }

    /**
     * Get idDepartment
     *
     * @return integer 
     */
    public function getIdDepartment()
    {
        return $this->idDepartment;
    }

    /**
     * Set department
     *
     * @param \Task1\Entity\Department $department
     * @return Vacancy
     */
    public function setDepartment(\Task1\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \Task1\Entity\Department 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Add translates
     *
     * @param \Task1\Entity\VacancyTrans $translates
     * @return Vacancy
     */
    public function addTranslate(\Task1\Entity\VacancyTrans $translates)
    {
        $this->translates[] = $translates;

        return $this;
    }

    /**
     * Remove translates
     *
     * @param \Task1\Entity\VacancyTrans $translates
     */
    public function removeTranslate(\Task1\Entity\VacancyTrans $translates)
    {
        $this->translates->removeElement($translates);
    }

    /**
     * Get translates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslates()
    {
        return $this->translates;
    }
	
	/**
	 * 
	 * @param string $lang
	 * @return \Task1\Entity\VacancyTrans
	 */
	public function getTranslateByLang($lang)
	{
		$criteria = Criteria::create();
		$criteria->where(Criteria::expr()->eq('lang', $lang));
		$result = $this->getTranslates()->matching($criteria);
		if ($result->isEmpty()) {
			return;
		}
		return $result->get(0);
	}
}
