<?php
namespace Sportacus\CoreBundle\Measures\Comparator;

use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Measures\Progression;
class Factory
{
    public function create(Measure $previousMeasure, Measure $newMeasure)
    {
        if($previousMeasure->getTypeMeasure() !== $newMeasure->getTypeMeasure()) {
            throw new Exception('Les 2 mesures doivent être du même type pour être comparées');
        }
        
        switch($previousMeasure->getTypeMeasure()->getTypeProgression())
        {
            case Progression::PROGRESS_IF_VALUE_IS_GREATER:
                return new GreaterThan();
            default:
                return new LowerThan();
        }
    }
}