<?php

namespace Sportacus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Form\Type\MeasureType;
use Symfony\Component\HttpFoundation\Request;
use Sportacus\CoreBundle\Form\Type\MeasureCollectionType;
use Sportacus\CoreBundle\Entity\TypeMeasure;

class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        $measure = new Measure();
        $measures = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportacusCoreBundle:Measure')
            ->findAllByUserGroupByDate($this->getUser())
        ;
        
        $aggregator = $this->get('measures.aggregator');
        
        $aggregatedMeasures = $aggregator->aggregateMeasuresByDate($measures, $this->get('measures.progression'));
        
        $typeMeasures = $this
        	->getDoctrine()
        	->getManager()
        	->getRepository('SportacusCoreBundle:TypeMeasure')
        	->findAll()
        ;

        $form = $this->createForm(new MeasureCollectionType($this->getDoctrine()), null, ['attr' => ['id' => 'formMeasures'],  'method' => 'POST', 'user' => $this->getUser()]);
        $form->handleRequest($request);

        $session = $request->getSession();
        $flashBag = $session->getFlashBag();
        
        if($form->isValid())
        {
            $measures = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('SportacusCoreBundle:Measure');
            
            foreach($measures as $measure)
            {
                if($measure instanceof Measure)
                {
                    $existingMeasure = $repository->findOneBy(array('date' => $measure->getDate(), 'typeMeasure' => $measure->getTypeMeasure(), 'user' => $measure->getUser()));
                    
                    
                    if(null !== $existingMeasure)
                    {
                        $existingMeasure->setValue($measure->getValue());
                        $em->persist($existingMeasure);
                    }
                    else
                    {
                        $em->persist($measure);
                    }  
                }
            }
            
            $em->flush();
            
            $flashBag->add('success', 'Vos mesures ont bien été enregistrées');
                        
            return $this->redirect($this->generateUrl('_homepage'));
        }
        elseif($form->isSubmitted()) {
            $flashBag->add('error', 'Il y a une ou plusieurs erreurs dans votre formulaire.');
        }
        
        
        return $this->render('SportacusCoreBundle:Home:index.html.twig', 
    		array(
				'measures' => $aggregatedMeasures,	
				'typeMeasures' => $typeMeasures,
				'form' => $form->createView(),
            )
        );
    }
}
