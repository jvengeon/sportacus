<?php

namespace Sportacus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="typeMeasure")
 */
class TypeMeasure
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
     * @ORM\Column(type="smallint")
     * Ce champ sert à définir la progression entre 2 mesures du même type
     * Si 1 alors la progression est positive si la mesure la plus récente est supérieur à la précedente
     * Si 0 alors la progression est positive si la mesure la plus récente est inférieur à la précédente
     */
    protected $typeProgression;

    /**
     * @ORM\OneToMany(targetEntity="Measure", mappedBy="typeMeasure")
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
     * @return TypeMeasure
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
     * @return TypeMeasure
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
     * @return TypeMeasure
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


    /**
     * Set typeProgression
     *
     * @param integer $typeProgression
     * @return TypeMeasure
     */
    public function setTypeProgression($typeProgression)
    {
        $this->typeProgression = $typeProgression;

        return $this;
    }

    /**
     * Get typeProgression
     *
     * @return integer 
     */
    public function getTypeProgression()
    {
        return $this->typeProgression;
    }
}
