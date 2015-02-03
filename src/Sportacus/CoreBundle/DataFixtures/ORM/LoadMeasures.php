<?php

namespace Sportacus\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Entity\TypeMeasure;

class LoadMeasuresData implements FixtureInterface
{
    const 
        PROGRESS_IF_VALUE_IS_GREATER = 1,
        PROGRESS_IF_VALUE_IS_LOWER = 0;
    
    public function load(ObjectManager $manager)
    {
        $measures = [
            ['2015-01-01', '88.7', '20.6', '40.1', '54.6', '101', '94', '102', '90'],
            ['2015-01-11', '88.5', '20.5', '40.3', '54.6', '100', '94', '102', '91'],
            ['2015-01-21', '88.2', '20.4', '40.5', '54.6', '100', '94', '103', '92'],
            ['2015-01-31', '88.1', '20.3', '40.7', '54.6', '99', '93', '103', '93'],
        ];
        
        $typeMeasures = [
            ['poids', 'kg', self::PROGRESS_IF_VALUE_IS_LOWER],
            ['masse graisseuse', '%', self::PROGRESS_IF_VALUE_IS_LOWER],
            ['masse musculaire', '%', self::PROGRESS_IF_VALUE_IS_GREATER],
            ['masse eau', '%', self::PROGRESS_IF_VALUE_IS_LOWER],
            ['tour de ventre', 'cm', self::PROGRESS_IF_VALUE_IS_LOWER],
            ['tour de taille', 'cm', self::PROGRESS_IF_VALUE_IS_LOWER],
            ['tour de pecs', 'cm', self::PROGRESS_IF_VALUE_IS_GREATER],
            ['tour de bras', 'cm', self::PROGRESS_IF_VALUE_IS_GREATER],
        ];
        
        
        foreach($typeMeasures as $index => $typeMeasureValues)
        {
            $typeMeasure = new TypeMeasure();
            $typeMeasure
                ->setName($typeMeasureValues[0])
                ->setUnit($typeMeasureValues[1])
                ->setTypeProgression($typeMeasureValues[2])
            ;
            
            $manager->persist($typeMeasure);
            $manager->flush();
            
            foreach($measures as $measureValues)
            {
                $measure = new Measure();
                $measure
                ->setDate(new \DateTime($measureValues[0]))
                ->setValue($measureValues[$index + 1])
                ->setTypeMeasure($typeMeasure)
                ;
            
                $manager->persist($measure);
                $manager->flush();
            }
        }
        
        
        
        
        
        
    }
}