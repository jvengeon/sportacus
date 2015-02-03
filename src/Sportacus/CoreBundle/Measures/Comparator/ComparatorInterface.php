<?php
namespace Sportacus\CoreBundle\Measures\Comparator;

use Sportacus\CoreBundle\Entity\Measure;

interface ComparatorInterface
{
    const 
        HAS_NO_PROGRESS = 0,
        HAS_PROGRESS = 1,
        IS_EQUALS = 2;
    
    public function hasProgress(Measure $previousMeasure, Measure $newMeasure);
}