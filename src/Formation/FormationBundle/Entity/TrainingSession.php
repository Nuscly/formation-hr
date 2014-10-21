<?php

namespace Formation\FormationBundle\Entity;

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
     * @ORM\OneToOne(targetEntity="TrainingMonitoring")
     * @ORM\JoinColumn(name="training_monitoring_id", referencedColumnName="id")
     **/
    private $trainingMonitoring;


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
     * @param \Formation\FormationBundle\Entity\TrainingEvent $trainingEvents
     * @return TrainingSession
     */
    public function addTrainingEvent(\Formation\FormationBundle\Entity\TrainingEvent $trainingEvents)
    {
        $this->trainingEvents[] = $trainingEvents;

        return $this;
    }

    /**
     * Remove trainingEvents
     *
     * @param \Formation\FormationBundle\Entity\TrainingEvent $trainingEvents
     */
    public function removeTrainingEvent(\Formation\FormationBundle\Entity\TrainingEvent $trainingEvents)
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
     * @param \Formation\FormationBundle\Entity\TrainingMonitoring $trainingMonitoring
     * @return TrainingSession
     */
    public function setTrainingMonitoring(\Formation\FormationBundle\Entity\TrainingMonitoring $trainingMonitoring = null)
    {
        $this->trainingMonitoring = $trainingMonitoring;

        return $this;
    }

    /**
     * Get trainingMonitoring
     *
     * @return \Formation\FormationBundle\Entity\TrainingMonitoring 
     */
    public function getTrainingMonitoring()
    {
        return $this->trainingMonitoring;
    }
}
