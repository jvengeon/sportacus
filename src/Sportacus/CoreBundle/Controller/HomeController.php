<?php

namespace Sportacus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Form\Type\MeasureType;

class HomeController extends Controller
{
    public function indexAction()
    {
        $measures = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportacusCoreBundle:Measure')
            ->findAllGroupByDate()
        ;
        
        $aggregatedMeasures = $this->aggregateMeasuresByDate($measures);

        $typeMeasures = $this
        	->getDoctrine()
        	->getManager()
        	->getRepository('SportacusCoreBundle:TypeMeasure')
        	->findAll()
        ;
        
        $form = $this->createForm(new MeasureType(), new Measure());
        
        return $this->render('SportacusCoreBundle:Home:index.html.twig', 
    		array(
				'measures' => $aggregatedMeasures,	
				'typeMeasures' => $typeMeasures,
				'form' => $form->createView(),
            )
        );
    }
    
    private function aggregateMeasuresByDate(array $measures)
    {
    	$aggregatedMeasures = [];
    	
        foreach($measures as $measure)
        {
        	if($measure instanceof Measure)
        	{
        		$aggregatedMeasures[$measure->getDate()->format('d-m-Y')][$measure->getTypeMeasure()->getName()] = $measure;
        	}
        }
        
        return $aggregatedMeasures;
        
    }
}
