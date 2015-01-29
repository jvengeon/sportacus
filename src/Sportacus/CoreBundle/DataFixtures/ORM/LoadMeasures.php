<?php

namespace Sportacus\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Entity\TypeMeasure;

class LoadMeasuresData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $measures = [
            ['2014-01-01', '88.7', '20.6', '40.1', '54.6', '101', '94'],
            ['2014-01-11', '88.5', '20.5', '40.3', '54.6', '100', '94'],
            ['2014-01-21', '88.2', '20.4', '40.5', '54.6', '100', '94'],
            ['2014-01-31', '88.1', '20.3', '40.7', '54.6', '99', '93'],
        ];
        
        $typeMeasures = [
            ['poids', 'kg'],
            ['masse graisseuse', '%'],
            ['masse musculaire', '%'],
            ['masse eau', '%'],
            ['tour de ventre', 'cm'],
            ['tour de taille', 'cm'],
        ];
        
        
        foreach($typeMeasures as $index => $typeMeasureValues)
        {
            $typeMeasure = new TypeMeasure();
            $typeMeasure
                ->setName($typeMeasureValues[0])
                ->setUnit($typeMeasureValues[1])
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