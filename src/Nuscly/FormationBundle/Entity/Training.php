<?php

namespace Nuscly\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Training
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Training
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
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="text")
     */
    private $domain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nextRetraining", type="date")
     */
    private $nextRetraining;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="date")
     */
    private $deadline;

    /**
     * @ORM\ManyToOne(targetEntity="Typology", inversedBy="trainings")
     * @ORM\JoinColumn(name="typology_id", referencedColumnName="id")
     **/
    private $typology;

    /**
     * @ORM\OneToMany(targetEntity="StateRequest", mappedBy="training")
     * @ORM\OrderBy({"date" = "ASC"})
     **/
    private $stateRequests;
    /**
     * @ORM\OneToMany(targetEntity="StateTraining", mappedBy="training")
     * @ORM\OrderBy({"date" = "ASC"})
     **/
    private $stateTrainings;
    /**
     * @ORM\OneToMany(targetEntity="StatePlan", mappedBy="training")
     * @ORM\OrderBy({"date" = "ASC"})
     **/
    private $statePlans;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="trainings")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     **/
    private $employee;


    public function __construct() {
        $this->stateRequests = new ArrayCollection();
        $this->stateTrainings = new ArrayCollection();
        $this->statePlans = new ArrayCollection();

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
     * Set title
     *
     * @param string $title
     * @return Training
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Training
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set nextRetraining
     *
     * @param \DateTime $nextRetraining
     * @return Training
     */
    public function setNextRetraining($nextRetraining)
    {
        $this->nextRetraining = $nextRetraining;

        return $this;
    }

    /**
     * Get nextRetraining
     *
     * @return \DateTime 
     */
    public function getNextRetraining()
    {
        return $this->nextRetraining;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Training
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set typology
     *
     * @param \Nuscly\FormationBundle\Entity\Typology $typology
     * @return Training
     */
    public function setTypology(\Nuscly\FormationBundle\Entity\Typology $typology = null)
    {
        $this->typology = $typology;

        return $this;
    }

    /**
     * Get typology
     *
     * @return \Nuscly\FormationBundle\Entity\Typology 
     */
    public function getTypology()
    {
        return $this->typology;
    }

    /**
     * Add stateRequests
     *
     * @param \Nuscly\FormationBundle\Entity\StateRequest $stateRequests
     * @return Training
     */
    public function addStateRequest(\Nuscly\FormationBundle\Entity\StateRequest $stateRequests)
    {
        $this->stateRequests[] = $stateRequests;

        return $this;
    }

    /**
     * Remove stateRequests
     *
     * @param \Nuscly\FormationBundle\Entity\StateRequest $stateRequests
     */
    public function removeStateRequest(\Nuscly\FormationBundle\Entity\StateRequest $stateRequests)
    {
        $this->stateRequests->removeElement($stateRequests);
    }

    /**
     * Get stateRequests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStateRequests()
    {
        return $this->stateRequests;
    }

    /**
     * Add stateTrainings
     *
     * @param \Nuscly\FormationBundle\Entity\StateTraining $stateTrainings
     * @return Training
     */
    public function addStateTraining(\Nuscly\FormationBundle\Entity\StateTraining $stateTrainings)
    {
        $this->stateTrainings[] = $stateTrainings;

        return $this;
    }

    /**
     * Remove stateTrainings
     *
     * @param \Nuscly\FormationBundle\Entity\StateTraining $stateTrainings
     */
    public function removeStateTraining(\Nuscly\FormationBundle\Entity\StateTraining $stateTrainings)
    {
        $this->stateTrainings->removeElement($stateTrainings);
    }

    /**
     * Get stateTrainings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStateTrainings()
    {
        return $this->stateTrainings;
    }

    /**
     * Add statePlans
     *
     * @param \Nuscly\FormationBundle\Entity\StatePlan $statePlans
     * @return Training
     */
    public function addStatePlan(\Nuscly\FormationBundle\Entity\StatePlan $statePlans)
    {
        $this->statePlans[] = $statePlans;

        return $this;
    }

    /**
     * Remove statePlans
     *
     * @param \Nuscly\FormationBundle\Entity\StatePlan $statePlans
     */
    public function removeStatePlan(\Nuscly\FormationBundle\Entity\StatePlan $statePlans)
    {
        $this->statePlans->removeElement($statePlans);
    }

    /**
     * Get statePlans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStatePlans()
    {
        return $this->statePlans;
    }

    /**
     * Set employee
     *
     * @param \Nuscly\FormationBundle\Entity\Employee $employee
     * @return Training
     */
    public function setEmployee(\Nuscly\FormationBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \Nuscly\FormationBundle\Entity\Employee 
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}
