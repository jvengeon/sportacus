<?php
namespace Sportacus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     */
    protected $value;
    
    /**
     * 
     * @ORM\Column(type="date")
     * @Assert\DateTime()
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="TypeMeasure", inversedBy="mesures")
     * @ORM\JoinColumn(name="typeMeasure_id", referencedColumnName="id")
     * @Assert\Type(type="Sportacus\CoreBundle\Entity\TypeMeasure")
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
     * @param \Sportacus\CoreBundle\Entity\TypeMeasure $typeMeasure
     * @return Measure
     */
    public function setTypeMeasure(\Sportacus\CoreBundle\Entity\TypeMeasure $typeMeasure = null)
    {
        $this->typeMeasure = $typeMeasure;

        return $this;
    }

    /**
     * Get typeMeasure
     *
     * @return \Sportacus\CoreBundle\Entity\TypeMeasure 
     */
    public function getTypeMeasure()
    {
        return $this->typeMeasure;
    }
}
