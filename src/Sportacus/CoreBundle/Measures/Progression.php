<?php
namespace Sportacus\CoreBundle\Measures;

use Sportacus\CoreBundle\Entity\Measure;
use Doctrine\Common\Persistence\ObjectManager;
use Sportacus\CoreBundle\Measures\Comparator\Factory;
use Sportacus\CoreBundle\Measures\Comparator\ComparatorInterface;

class Progression
{
    const
        NO_MEASURE = 2,
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
    
    /*
     * 0 -> FAILED
     * 1 -> SUCCESS
     * 2 -> NO MEASURE REGISTERED AFTER THE GOAL'S DATE
     *  
     */
    public function getGoalStatus(Measure $goal)
    {
        $status = self::NO_MEASURE;
        
        $nextMeasure = $this->entityManager
             ->getRepository('SportacusCoreBundle:Measure')
             ->findOneNextMeasure($goal)
        ;

        
        if($nextMeasure !== null){
            $comparator = $this->comparatorFactory->create($goal, $nextMeasure);
            $status = $comparator->isSuccess($goal, $nextMeasure);
            
        }
        
        return $status;
        
    }
    
}