<?php

namespace Nuscly\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StateRequest
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class StateRequest
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
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     **/
    private $state;


    /**
     * @ORM\ManyToOne(targetEntity="Training", inversedBy="stateRequests")
     * @ORM\JoinColumn(name="training_id", referencedColumnName="id", nullable=false)
     **/
    private $training;


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
     * @return StateRequest
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
     * @return StateRequest
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
     * @return StateRequest
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
     * Set training
     *
     * @param \Nuscly\FormationBundle\Entity\Training $training
     * @return StateRequest
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


    public function __toString()
    {
        if ($this->getState()!=NULL)
            return $this->getState()->getName().' '.$this->getComment();
        else
            return $this->getComment();
    }
}
