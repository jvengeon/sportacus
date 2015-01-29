<?php
namespace Sportacus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sportacus\CoreBundle\Repository\MeasureRepository")
 * @ORM\Table(name="measure")
 */
class Measure
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="decimal", scale=1)
     */
    protected $value;
    
    /**
     * 
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="MeasureType", inversedBy="mesures")
     * @ORM\JoinColumn(name="typeMeasure_id", referencedColumnName="id")
     */
    protected $typeMeasure;
    
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
     * Set value
     *
     * @param string $value
     * @return Measure
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Measure
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
     * Set typeMeasure
     *
     * @param \Sportacus\CoreBundle\Entity\MeasureType $typeMeasure
     * @return Measure
     */
    public function setTypeMeasure(\Sportacus\CoreBundle\Entity\MeasureType $typeMeasure = null)
    {
        $this->typeMeasure = $typeMeasure;

        return $this;
    }

    /**
     * Get typeMeasure
     *
     * @return \Sportacus\CoreBundle\Entity\MeasureType 
     */
    public function getTypeMeasure()
    {
        return $this->typeMeasure;
    }
}
