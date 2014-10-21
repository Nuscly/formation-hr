<?php

namespace Nuscly\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Employee
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nuscly\FormationBundle\Entity\EmployeeRepository")
 */
class Employee
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var \Date
     *
     * @ORM\Column(name="arrivalDate", type="date")
     */
    private $arrivalDate;

    /**
     * @var text
     *
     * @ORM\Column(name="arrivalReason", type="text")
     */
    private $arrivalReason;


    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="employees")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     **/
    private $department;


    /**
     * @ORM\OneToMany(targetEntity="Training", mappedBy="employee")
     **/
    private $trainings;


    public function __construct() {
        $this->trainings = new ArrayCollection();
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
     * @return Employee
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
     * Set surname
     *
     * @param string $surname
     * @return Employee
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set arrivalDate
     *
     * @param \DateTime $arrivalDate
     * @return Employee
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    /**
     * Get arrivalDate
     *
     * @return \DateTime
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * Set arrivalReason
     *
     * @param string $arrivalReason
     * @return Employee
     */
    public function setArrivalReason($arrivalReason)
    {
        $this->arrivalReason = $arrivalReason;

        return $this;
    }

    /**
     * Get arrivalReason
     *
     * @return string
     */
    public function getArrivalReason()
    {
        return $this->arrivalReason;
    }

    /**
     * Set department
     *
     * @param \Nuscly\FormationBundle\Entity\Department $department
     * @return Employee
     */
    public function setDepartment(\Nuscly\FormationBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \Nuscly\FormationBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Add trainings
     *
     * @param \Nuscly\FormationBundle\Entity\Training $trainings
     * @return Employee
     */
    public function addTraining(\Nuscly\FormationBundle\Entity\Training $trainings)
    {
        $this->trainings[] = $trainings;

        return $this;
    }

    /**
     * Remove trainings
     *
     * @param \Nuscly\FormationBundle\Entity\Training $trainings
     */
    public function removeTraining(\Nuscly\FormationBundle\Entity\Training $trainings)
    {
        $this->trainings->removeElement($trainings);
    }

    /**
     * Get trainings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrainings()
    {
        return $this->trainings;
    }

    public function __toString()
    {
        return $this->name.' '.$this->surname;
    }


}
