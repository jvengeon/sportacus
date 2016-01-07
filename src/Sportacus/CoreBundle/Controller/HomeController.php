<?php

namespace Sportacus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Form\Type\MeasureType;
use Symfony\Component\HttpFoundation\Request;
use Sportacus\CoreBundle\Form\Type\MeasureCollectionType;
use Sportacus\CoreBundle\Entity\TypeMeasure;
use Sportacus\CoreBundle\Entity\Goal;

class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        
        if($user === null)
        {
            $user = $this->getDoctrine()->getManager()
            ->getRepository('SportacusCoreBundle:User')
            ->find(2)
            ;
        }
        
        $nextGoals = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportacusCoreBundle:Measure')
            ->findNextGoalsByUser($user)
        ;
        
        $lastGoals = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportacusCoreBundle:Measure')
            ->findLastGoalsByUser($user)
        ;
  
        $measure = new Measure();
        $measures = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportacusCoreBundle:Measure')
            ->findAllByUserGroupByDate($user)
        ;
        
        $aggregator = $this->get('measures.aggregator');
        
        $aggregatedMeasures = $aggregator->aggregateMeasuresByDate($measures, $this->get('measures.progression'));
        
        $aggregatedLastGoals = $aggregator->aggregateGoals($lastGoals, $this->get('measures.progression'));
        
        $typeMeasures = $this
        	->getDoctrine()
        	->getManager()
        	->getRepository('SportacusCoreBundle:TypeMeasure')
        	->findAll()
        ;

        $form = $this->createForm(new MeasureCollectionType($this->getDoctrine()), null, ['attr' => ['id' => 'formMeasures'],  'method' => 'POST', 'user' => $user]);
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
                    $existingMeasure = $repository->findOneBy(array('date' => $measure->getDate(),'isGoal' => 0, 'typeMeasure' => $measure->getTypeMeasure(), 'user' => $measure->getUser()));
                    
                    
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
    		    'nextGoals' => $nextGoals,
    		    'lastGoals' => $aggregatedLastGoals,
				'measures' => $aggregatedMeasures,	
				'typeMeasures' => $typeMeasures,
				'form' => $form->createView(),
            )
        );
    }
}
