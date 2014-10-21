<?php

namespace Nuscly\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Department
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Department
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
     * @ORM\OneToMany(targetEntity="Department", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parent;


    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="department")
     **/
    private $employees;



    public function __construct() {
        $this->children = new ArrayCollection();
        $this->employees = new ArrayCollection();
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
     * Add children
     *
     * @param \Nuscly\FormationBundle\Entity\Department $children
     * @return Department
     */
    public function addChild(\Nuscly\FormationBundle\Entity\Department $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Nuscly\FormationBundle\Entity\Department $children
     */
    public function removeChild(\Nuscly\FormationBundle\Entity\Department $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Nuscly\FormationBundle\Entity\Department $parent
     * @return Department
     */
    public function setParent(\Nuscly\FormationBundle\Entity\Department $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Nuscly\FormationBundle\Entity\Department
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add employees
     *
     * @param \Nuscly\FormationBundle\Entity\Employee $employees
     * @return Department
     */
    public function addEmployee(\Nuscly\FormationBundle\Entity\Employee $employees)
    {
        $this->employees[] = $employees;

        return $this;
    }

    /**
     * Remove employees
     *
     * @param \Nuscly\FormationBundle\Entity\Employee $employees
     */
    public function removeEmployee(\Nuscly\FormationBundle\Entity\Employee $employees)
    {
        $this->employees->removeElement($employees);
    }

    /**
     * Get employees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getFullName()
    {
        if ($this->getParent()!=NULL)
            return $this->getParent()->getName().' / '.$this->getName();
        else
            return $this->getName();
    }


}
