<?php
namespace Sportacus\CoreBundle\Measures\Comparator;

use Sportacus\CoreBundle\Entity\Measure;

class GreaterThan implements ComparatorInterface
{
    public function hasProgress(Measure $previousMeasure, Measure $newMeasure)
    {
        if($newMeasure->getValue() > $previousMeasure->getValue()) {
            return self::HAS_PROGRESS;
        } elseif($newMeasure->getValue() == $previousMeasure->getValue()) {
            return self::IS_EQUALS;
        }
        
        return self::HAS_NO_PROGRESS;
        
    }
}