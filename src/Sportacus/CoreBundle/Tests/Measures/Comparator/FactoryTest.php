<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sportacus\CoreBundle\Measures\Progression;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Entity\TypeMeasure;
use Sportacus\CoreBundle\Measures\Comparator\Factory;

class FactoryTest extends WebTestCase
{
    protected 
        $measureWithType1,
        $measureWithType2,
        $measureWithType3
    ;
    
    public function setUp()
    {
        $typeMeasure1 = (new TypeMeasure())->setName('poids')
                                           ->setUnit('kg')
                                           ->setTypeProgression(Progression::PROGRESS_IF_VALUE_IS_LOWER);
        
        $typeMeasure2 = (new TypeMeasure())->setName('masse graisseuse')
                                           ->setUnit('%')
                                           ->setTypeProgression(Progression::PROGRESS_IF_VALUE_IS_LOWER);
        
        $typeMeasure3 = (new TypeMeasure())->setName('masse musculaire')
                                           ->setUnit('%')
                                           ->setTypeProgression(Progression::PROGRESS_IF_VALUE_IS_GREATER);
        
       $this->measureWithType1 = (new Measure())->setDate(new \DateTime())
                                                ->setTypeMeasure($typeMeasure1)
                                                ->setValue('88.8');
       
       $this->measureWithType2 = (new Measure())->setDate(new \DateTime())
                                                ->setTypeMeasure($typeMeasure2)
                                                ->setValue('20.4');
       
       $this->measureWithType3 = (new Measure())->setDate(new \DateTime())
                                                ->setTypeMeasure($typeMeasure3)
                                                ->setValue('100');
        
        
    }
    
    /**
     * @dataProvider createProvider
     */
    public function testCreate($measure1, $measure2, $expected)
    {
        $factory = new Factory();
        $result = $factory->create($measure1, $measure2);
       
        $this->assertInstanceOf($expected, $result);
    }
    
    /**
     * @expectedException \Sportacus\CoreBundle\Measures\Comparator\Exception
     * @dataProvider createProviderForErrors
     */
    public function testCreateFailedWithTwoDifferentTypeOfMeasure($measure1, $measure2)
    {
        $factory = new Factory();
        $factory->create($measure1, $measure2);
    }
    
    
    public function createProvider()
    {
        $this->setUp();   
        return [
            [$this->measureWithType1, $this->measureWithType1, '\Sportacus\CoreBundle\Measures\Comparator\LowerThan'],
            [$this->measureWithType3, $this->measureWithType3, '\Sportacus\CoreBundle\Measures\Comparator\GreaterThan'],
        ];
    }
    
    public function createProviderForErrors()
    {
        $this->setUp();   
        return [
            [$this->measureWithType1, $this->measureWithType2],
            [$this->measureWithType2, $this->measureWithType3],
        ];
    }
}