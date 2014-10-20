<?php

namespace Formation\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="nextRetraining", type="datetime")
     */
    private $nextRetraining;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime")
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
     * @param \Formation\FormationBundle\Entity\Typology $typology
     * @return Training
     */
    public function setTypology(\Formation\FormationBundle\Entity\Typology $typology = null)
    {
        $this->typology = $typology;

        return $this;
    }

    /**
     * Get typology
     *
     * @return \Formation\FormationBundle\Entity\Typology 
     */
    public function getTypology()
    {
        return $this->typology;
    }

    /**
     * Add stateRequests
     *
     * @param \Formation\FormationBundle\Entity\StateRequest $stateRequests
     * @return Training
     */
    public function addStateRequest(\Formation\FormationBundle\Entity\StateRequest $stateRequests)
    {
        $this->stateRequests[] = $stateRequests;

        return $this;
    }

    /**
     * Remove stateRequests
     *
     * @param \Formation\FormationBundle\Entity\StateRequest $stateRequests
     */
    public function removeStateRequest(\Formation\FormationBundle\Entity\StateRequest $stateRequests)
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
     * @param \Formation\FormationBundle\Entity\StateTraining $stateTrainings
     * @return Training
     */
    public function addStateTraining(\Formation\FormationBundle\Entity\StateTraining $stateTrainings)
    {
        $this->stateTrainings[] = $stateTrainings;

        return $this;
    }

    /**
     * Remove stateTrainings
     *
     * @param \Formation\FormationBundle\Entity\StateTraining $stateTrainings
     */
    public function removeStateTraining(\Formation\FormationBundle\Entity\StateTraining $stateTrainings)
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
     * @param \Formation\FormationBundle\Entity\StatePlan $statePlans
     * @return Training
     */
    public function addStatePlan(\Formation\FormationBundle\Entity\StatePlan $statePlans)
    {
        $this->statePlans[] = $statePlans;

        return $this;
    }

    /**
     * Remove statePlans
     *
     * @param \Formation\FormationBundle\Entity\StatePlan $statePlans
     */
    public function removeStatePlan(\Formation\FormationBundle\Entity\StatePlan $statePlans)
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
}
