<?php
namespace Sportacus\CoreBundle\Measures;

use Sportacus\CoreBundle\Entity\Measure;
use Doctrine\Common\Persistence\ObjectManager;




class Aggregator
{
    private $entityManager;
    
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function aggregateMeasuresByDate(array $measures, Progression $progressionObject)
    {
        $aggregatedMeasures = [];
         
        foreach($measures as $measure)
        {
            if($measure instanceof Measure) {
                $progression = $progressionObject->getProgression($measure)
                                ;
                $measure->progression = $progression;

                $aggregatedMeasures[$measure->getDate()->format('d/m/Y')][$measure->getTypeMeasure()->getName()] = $measure;
            }
        }

        return $aggregatedMeasures;
    }
    
    public function aggregateGoals(array $goals, Progression $progressionObject)
    {
        $aggregatedGoals = [];
        
        foreach($goals as $goal)
        {
            if($goal instanceof Measure)
            {
                $status = $progressionObject->getGoalStatus($goal);
                $goal->status = $status;
                
                $aggregatedGoals[] = $goal;
            }
        }
        
        return $aggregatedGoals;
    }
}