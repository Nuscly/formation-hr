<?php

namespace Formation\FormationBundle\Entity;

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
     * @param \Formation\FormationBundle\Entity\Department $children
     * @return Department
     */
    public function addChild(\Formation\FormationBundle\Entity\Department $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Formation\FormationBundle\Entity\Department $children
     */
    public function removeChild(\Formation\FormationBundle\Entity\Department $children)
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
     * @param \Formation\FormationBundle\Entity\Department $parent
     * @return Department
     */
    public function setParent(\Formation\FormationBundle\Entity\Department $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Formation\FormationBundle\Entity\Department 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add employees
     *
     * @param \Formation\FormationBundle\Entity\Employee $employees
     * @return Department
     */
    public function addEmployee(\Formation\FormationBundle\Entity\Employee $employees)
    {
        $this->employees[] = $employees;

        return $this;
    }

    /**
     * Remove employees
     *
     * @param \Formation\FormationBundle\Entity\Employee $employees
     */
    public function removeEmployee(\Formation\FormationBundle\Entity\Employee $employees)
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



}
