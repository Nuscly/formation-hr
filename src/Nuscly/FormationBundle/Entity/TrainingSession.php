<?php

namespace Nuscly\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TrainingSession
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TrainingSession
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
     * @ORM\ManyToMany(targetEntity="TrainingEvent")
     * @ORM\JoinTable(name="trainingSession_trainingEvent",
     *      joinColumns={@ORM\JoinColumn(name="trainingSession_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="trainingEvent_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    private $trainingEvents;

    /**
     * @var string
     *
     * @ORM\Column(name="numberOfDays", type="decimal")
     */
    private $numberOfDays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     **/
    private $state;


    /**
     * @ORM\OneToOne(targetEntity="TrainingMonitoring", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="training_monitoring_id", referencedColumnName="id")
     **/
    private $trainingMonitoring;

    /**
     * @ORM\ManyToOne(targetEntity="Training", inversedBy="trainingsSession")
     * @ORM\JoinColumn(name="training_id", referencedColumnName="id", nullable=false)
     **/
    private $training;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    public function __construct()
    {
        $this->trainingEvents = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return StateTraining
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return StateTraining
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set state
     *
     * @param \Nuscly\FormationBundle\Entity\State $state
     * @return StateTraining
     */
    public function setState(\Nuscly\FormationBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Nuscly\FormationBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set numberOfDays
     *
     * @param string $numberOfDays
     * @return TrainingSession
     */
    public function setNumberOfDays($numberOfDays)
    {
        $this->numberOfDays = $numberOfDays;

        return $this;
    }

    /**
     * Get numberOfDays
     *
     * @return string 
     */
    public function getNumberOfDays()
    {
        return $this->numberOfDays;
    }

    /**
     * Add trainingEvents
     *
     * @param \Nuscly\FormationBundle\Entity\TrainingEvent $trainingEvents
     * @return TrainingSession
     */
    public function addTrainingEvent(\Nuscly\FormationBundle\Entity\TrainingEvent $trainingEvents)
    {
        $this->trainingEvents[] = $trainingEvents;

        return $this;
    }

    /**
     * Remove trainingEvents
     *
     * @param \Nuscly\FormationBundle\Entity\TrainingEvent $trainingEvents
     */
    public function removeTrainingEvent(\Nuscly\FormationBundle\Entity\TrainingEvent $trainingEvents)
    {
        $this->trainingEvents->removeElement($trainingEvents);
    }

    /**
     * Get trainingEvents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrainingEvents()
    {
        return $this->trainingEvents;
    }

    /**
     * Set trainingMonitoring
     *
     * @param \Nuscly\FormationBundle\Entity\TrainingMonitoring $trainingMonitoring
     * @return TrainingSession
     */
    public function setTrainingMonitoring(\Nuscly\FormationBundle\Entity\TrainingMonitoring $trainingMonitoring = null)
    {
        $this->trainingMonitoring = $trainingMonitoring;

        return $this;
    }

    /**
     * Get trainingMonitoring
     *
     * @return \Nuscly\FormationBundle\Entity\TrainingMonitoring 
     */
    public function getTrainingMonitoring()
    {
        return $this->trainingMonitoring;
    }

    /**
     * Set training
     *
     * @param \Nuscly\FormationBundle\Entity\Training $training
     * @return StateTraining
     */
    public function setTraining(\Nuscly\FormationBundle\Entity\Training $training = null)
    {
        $this->training = $training;

        return $this;
    }

    /**
     * Get training
     *
     * @return \Nuscly\FormationBundle\Entity\Training
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function __toString()
    {
        return $this->getState()->getName();
    }

}
