<?php

namespace Sportacus\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Entity\MeasureType;

class LoadMeasuresData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $measures = [
            ['2014-01-01', '88.7'],
            ['2014-01-11', '88.5'],
            ['2014-01-21', '88.2'],
            ['2014-01-31', '88.1'],
        ];
        
        $typeMeasures = [
            ['poids', 'kg'],
            ['masse graisseuse', '%'],
            ['masse musculaire', '%'],
            ['masse eau', '%'],
            ['tour de ventre', 'cm'],
            ['tour de taille', 'cm'],
        ];
        
        $firstTypeMeasure = null;
        
        foreach($typeMeasures as $index => $typeMeasureValues)
        {
            $typeMeasure = new MeasureType();
            $typeMeasure
                ->setName($typeMeasureValues[0])
                ->setUnit($typeMeasureValues[1])
            ;
            
            $manager->persist($typeMeasure);
            $manager->flush();
            
            if($index === 0)
            {
                $firstTypeMeasure = $typeMeasure;
            }
        }
        
        
        
        foreach($measures as $measureValues)
        {
            $measure = new Measure();
            $measure
                ->setDate(new \DateTime($measureValues[0]))
                ->setValue($measureValues[1])
                ->setTypeMeasure($firstTypeMeasure)
            ;
            
            $manager->persist($measure);
            $manager->flush();
        }
        
        
    }
}