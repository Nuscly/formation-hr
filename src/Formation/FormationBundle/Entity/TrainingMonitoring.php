<?php

namespace Formation\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingMonitoring
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TrainingMonitoring
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
     * @var boolean
     *
     * @ORM\Column(name="inscription", type="boolean")
     */
    private $inscription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmation", type="boolean")
     */
    private $confirmation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="convocation", type="boolean")
     */
    private $convocation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="certificate", type="boolean")
     */
    private $certificate;


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
     * Set inscription
     *
     * @param boolean $inscription
     * @return TrainingMonitoring
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return boolean 
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set confirmation
     *
     * @param boolean $confirmation
     * @return TrainingMonitoring
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return boolean 
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Set convocation
     *
     * @param boolean $convocation
     * @return TrainingMonitoring
     */
    public function setConvocation($convocation)
    {
        $this->convocation = $convocation;

        return $this;
    }

    /**
     * Get convocation
     *
     * @return boolean 
     */
    public function getConvocation()
    {
        return $this->convocation;
    }

    /**
     * Set certificate
     *
     * @param boolean $certificate
     * @return TrainingMonitoring
     */
    public function setCertificate($certificate)
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * Get certificate
     *
     * @return boolean 
     */
    public function getCertificate()
    {
        return $this->certificate;
    }
}
