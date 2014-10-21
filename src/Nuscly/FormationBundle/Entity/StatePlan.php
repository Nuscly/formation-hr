<?php

namespace Nuscly\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatePlan
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class StatePlan
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
     * @ORM\OneToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     **/
    private $state;


    /**
     * @ORM\ManyToOne(targetEntity="Training", inversedBy="statePlans")
     * @ORM\JoinColumn(name="training_id", referencedColumnName="id")
     **/
    private $training;


    /**
     * @ORM\ManyToOne(targetEntity="TrainingPlan")
     * @ORM\JoinColumn(name="training_plan_id", referencedColumnName="id")
     **/
    private $trainingPlan;


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
     * @return StatePlan
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
     * @return StatePlan
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
     * @param \Formation\FormationBundle\Entity\State $state
     * @return StatePlan
     */
    public function setState(\Nuscly\FormationBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Formation\FormationBundle\Entity\State 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set training
     *
     * @param \Formation\FormationBundle\Entity\Training $training
     * @return StatePlan
     */
    public function setTraining(\Nuscly\FormationBundle\Entity\Training $training = null)
    {
        $this->training = $training;

        return $this;
    }

    /**
     * Get training
     *
     * @return \Formation\FormationBundle\Entity\Training 
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * @return mixed
     */
    public function getTrainingPlan()
    {
        return $this->trainingPlan;
    }

    /**
     * @param mixed $trainingPlan
     */
    public function setTrainingPlan($trainingPlan)
    {
        $this->trainingPlan = $trainingPlan;
    }
}
