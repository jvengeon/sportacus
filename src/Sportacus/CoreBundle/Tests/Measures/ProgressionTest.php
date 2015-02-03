<?php

namespace Sportacus\CoreBundle\Tests\Measures;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sportacus\CoreBundle\Measures\Progression;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Entity\TypeMeasure;
use Sportacus\CoreBundle\Measures\Comparator\Factory;
use Sportacus\CoreBundle\Measures\Comparator\ComparatorInterface;

class ProgressionTest extends WebTestCase
{
    protected $typeMeasureWithTypeProgressionLowerThan,
              $typeMeasureWithTypeProgressionGreaterThan,
              $measureWithProgressionLowerThan,
              $measureWithProgressionGreatherThan,
              $measureRepository,
              $entityManager
    ;  
    
    public function setUp()
    {
        $this->generateTypeMeasureWithTypeProgressionLowerThan();
        $this->generateTypeMeasureWithTypeProgressionGreaterThan();
        
        $this->generateMeasureWithProgressionLowerthan();
        $this->generateMeasureWithProgressionGreaterthan();
        
        // Maintenant, mockez le repository pour qu'il retourne un mock de l'objet emloyee
        $this->measureRepository = $this->getMockBuilder('\Sportacus\CoreBundle\Repository\MeasureRepository')
            ->disableOriginalConstructor()
            ->getMock();
        
        // Et enfin, mockez l'EntityManager pour qu'il retourne un mock du repository
        $this->entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
        ->disableOriginalConstructor()
        ->getMock();
        
    }
    
    /**
     * @dataProvider progressionProvider
     */
    public function testGetProgression($previousMeasure, $newMeasure, $expected)
    {
        $this->measureRepository ->expects($this->any())
            ->method('findOnePreviousMeasure')
            ->will($this->returnValue($previousMeasure));
        

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->measureRepository));
        
        $progression = new Progression($this->entityManager, new Factory());
        
        
        
        $progress = $progression->getProgression($newMeasure);
        
        $this->assertEquals($expected, $progress);
        
    }
    
    public function progressionProvider()
    {
        $this->setUp();

        return [
            [$this->measureWithProgressionLowerThan, $this->getNewMeasureWithProgressionLowerThan(85), ComparatorInterface::HAS_PROGRESS],
            [$this->measureWithProgressionLowerThan, $this->getNewMeasureWithProgressionLowerThan(88), ComparatorInterface::IS_EQUALS],
            [$this->measureWithProgressionLowerThan, $this->getNewMeasureWithProgressionLowerThan(100), ComparatorInterface::HAS_NO_PROGRESS],
            [$this->measureWithProgressionGreatherThan, $this->getNewMeasureWithProgressionGreaterThan(100), ComparatorInterface::HAS_PROGRESS],
            [$this->measureWithProgressionGreatherThan, $this->getNewMeasureWithProgressionGreaterThan(30), ComparatorInterface::HAS_NO_PROGRESS],
            [$this->measureWithProgressionGreatherThan, $this->getNewMeasureWithProgressionGreaterThan(40.7), ComparatorInterface::IS_EQUALS],
        ];
    }
    
    private function generateTypeMeasureWithTypeProgressionLowerThan()
    {
        $this->typeMeasureWithTypeProgressionLowerThan = $this->getMock('\Sportacus\CoreBundle\Entity\TypeMeasure');
        
        $this->typeMeasureWithTypeProgressionLowerThan
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Poids'));
        
        $this->typeMeasureWithTypeProgressionLowerThan
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('1'));
        
        $this->typeMeasureWithTypeProgressionLowerThan
            ->expects($this->any())
            ->method('getTypeProgression')
            ->will($this->returnValue(0));
    }
    
    private function generateTypeMeasureWithTypeProgressionGreaterThan()
    {
        $this->typeMeasureWithTypeProgressionGreaterThan = $this->getMock('\Sportacus\CoreBundle\Entity\TypeMeasure');
        
        $this->typeMeasureWithTypeProgressionGreaterThan
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Masse musculaire'));
        
        $this->typeMeasureWithTypeProgressionGreaterThan
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('3'));
        
        $this->typeMeasureWithTypeProgressionGreaterThan
            ->expects($this->any())
            ->method('getTypeProgression')
            ->will($this->returnValue(1));
    }
    
    private function generateMeasureWithProgressionLowerthan()
    {
        // Premièrement, mockez l'objet qui va être utilisé dans le test
        $this->measureWithProgressionLowerThan = $this->getMock('\Sportacus\CoreBundle\Entity\Measure');
        
        $this->measureWithProgressionLowerThan->expects($this->any())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime('2015-01-17')));
        
        $this->measureWithProgressionLowerThan->expects($this->any())
            ->method('getValue')
            ->will($this->returnValue(88));
        
        $this->measureWithProgressionLowerThan->expects($this->any())
            ->method('getTypeMeasure')
            ->will($this->returnValue($this->typeMeasureWithTypeProgressionLowerThan));
    }
    
    private function generateMeasureWithProgressionGreaterthan()
    {
        // Premièrement, mockez l'objet qui va être utilisé dans le test
        $this->measureWithProgressionGreatherThan = $this->getMock('\Sportacus\CoreBundle\Entity\Measure');
        
        $this->measureWithProgressionGreatherThan->expects($this->any())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime('2015-01-17')));
        
        $this->measureWithProgressionGreatherThan->expects($this->any())
            ->method('getValue')
            ->will($this->returnValue(40.7));
        
        $this->measureWithProgressionGreatherThan->expects($this->any())
            ->method('getTypeMeasure')
            ->will($this->returnValue($this->typeMeasureWithTypeProgressionGreaterThan));
    }
    
    private function getNewMeasureWithProgressionLowerThan($value)
    {
        $newMeasure = $this->getMock('\Sportacus\CoreBundle\Entity\Measure');
        $newMeasure->expects($this->any())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime('2015-01-18')));
        
        $newMeasure->expects($this->any())
            ->method('getValue')
            ->will($this->returnValue($value));
        
        $newMeasure->expects($this->any())
            ->method('getTypeMeasure')
            ->will($this->returnValue($this->typeMeasureWithTypeProgressionLowerThan));
        
        return $newMeasure;
    }
    
    private function getNewMeasureWithProgressionGreaterThan($value)
    {
        $newMeasure = $this->getMock('\Sportacus\CoreBundle\Entity\Measure');
        $newMeasure->expects($this->any())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime('2015-01-18')));
        
        $newMeasure->expects($this->any())
            ->method('getValue')
            ->will($this->returnValue($value));
        
        $newMeasure->expects($this->any())
            ->method('getTypeMeasure')
            ->will($this->returnValue($this->typeMeasureWithTypeProgressionGreaterThan));
        
        return $newMeasure;
    }
}