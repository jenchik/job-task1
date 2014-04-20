<?php

namespace Task1\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VacancyTrans
 *
 * @ORM\Table(name="vacancy_trans", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}), @ORM\UniqueConstraint(name="lang", columns={"id_vacancy", "lang"})}, indexes={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity
 */
class VacancyTrans
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
     * @ORM\Column(name="id_vacancy", type="bigint", nullable=true)
     */
    private $idVacancy;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=8, nullable=false)
     */
    private $lang = 'en_US';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="desc", type="text", nullable=false)
     */
    private $desc;

	/**
     *
	 * @ORM\ManyToOne(targetEntity="Vacancy")
	 * @ORM\JoinColumn(name="id_vacancy", referencedColumnName="id")
     */
    private $vacancy;



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
     * Set idVacancy
     *
     * @param integer $idVacancy
     * @return VacancyTrans
     */
    public function setIdVacancy($idVacancy)
    {
        $this->idVacancy = $idVacancy;

        return $this;
    }

    /**
     * Get idVacancy
     *
     * @return integer 
     */
    public function getIdVacancy()
    {
        return $this->idVacancy;
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return VacancyTrans
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return VacancyTrans
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
     * Set desc
     *
     * @param string $desc
     * @return VacancyTrans
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get desc
     *
     * @return string 
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Set vacancy
     *
     * @param \Task1\Entity\Vacancy $vacancy
     * @return VacancyTrans
     */
    public function setVacancy(\Task1\Entity\Vacancy $vacancy = null)
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    /**
     * Get vacancy
     *
     * @return \Task1\Entity\Vacancy 
     */
    public function getVacancy()
    {
        return $this->vacancy;
    }
}
