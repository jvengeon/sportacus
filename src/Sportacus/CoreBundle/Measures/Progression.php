<?php
namespace Sportacus\CoreBundle\Measures;

use Sportacus\CoreBundle\Entity\Measure;
use Doctrine\Common\Persistence\ObjectManager;
use Sportacus\CoreBundle\Measures\Comparator\Factory;
use Sportacus\CoreBundle\Measures\Comparator\ComparatorInterface;

class Progression
{
    const
        PROGRESS_IF_VALUE_IS_GREATER = 1,
        PROGRESS_IF_VALUE_IS_LOWER = 0;
         
    private 
        $entityManager,
        $comparatorFactory,
        $measure
    ;
    
    public function __construct(ObjectManager $entityManager, Factory $comparatorFactory)
    {
        $this->entityManager = $entityManager;
        $this->comparatorFactory = $comparatorFactory;
    }
    
    
    public function getProgression(Measure $measure)
    {
        $hasProgress = ComparatorInterface::IS_EQUALS;
        
        $previousMeasure = $this->entityManager
             ->getRepository('SportacusCoreBundle:Measure')
             ->findOnePreviousMeasure($measure)
        ;
        
        if($previousMeasure !== null){
            $comparator = $this->comparatorFactory->create($previousMeasure, $measure);
            $hasProgress = $comparator->hasProgress($previousMeasure, $measure);
            
        }
        
        return $hasProgress;
    }
}