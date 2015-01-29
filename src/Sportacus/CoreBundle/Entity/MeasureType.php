<?php

namespace Sportacus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="measureType")
 */
class MeasureType
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=5)
     */
    protected $unit;

    /**
     * @ORM\OneToMany(targetEntity="Measure", mappedBy="mesureType")
     */
    protected $mesures;
    
    public function __construct()
    {
        $this->mesures = new ArrayCollection();
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
     * @return MeasureType
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
     * Set unit
     *
     * @param string $unit
     * @return MeasureType
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Add mesures
     *
     * @param \Sportacus\CoreBundle\Entity\Measure $mesures
     * @return MeasureType
     */
    public function addMesure(\Sportacus\CoreBundle\Entity\Measure $mesures)
    {
        $this->mesures[] = $mesures;

        return $this;
    }

    /**
     * Remove mesures
     *
     * @param \Sportacus\CoreBundle\Entity\Measure $mesures
     */
    public function removeMesure(\Sportacus\CoreBundle\Entity\Measure $mesures)
    {
        $this->mesures->removeElement($mesures);
    }

    /**
     * Get mesures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesures()
    {
        return $this->mesures;
    }
}
