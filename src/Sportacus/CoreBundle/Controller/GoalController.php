<?php

namespace Sportacus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sportacus\CoreBundle\Entity\Measure;
use Sportacus\CoreBundle\Form\Type\MeasureType;
use Symfony\Component\HttpFoundation\Request;
use Sportacus\CoreBundle\Form\Type\MeasureCollectionType;
use Sportacus\CoreBundle\Entity\TypeMeasure;

class GoalController extends Controller
{
    public function indexAction(Request $request, $id)
    {
        $existingMeasure = null;
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SportacusCoreBundle:Measure');
        
        if($user === null)
        {
            $user = $this->getDoctrine()->getManager()
            ->getRepository('SportacusCoreBundle:User')
            ->find(2)
            ;
        }
        
        if(is_null($id)) //creation mod
        {
            $measure = new Measure();
        }
        else 
        {
            $measure = $repository->find($id);
        }
        
        $form = $this->createForm(new MeasureType($this->getDoctrine()), $measure, ['attr' => ['id' => 'formGoal'],  'method' => 'POST', 'user' => $user, 'isGoal' => 1, 'hasSubmit' => true]);
        $form->handleRequest($request);

        $session = $request->getSession();
        $flashBag = $session->getFlashBag();
        
        if($form->isValid())
        {
            $measure = $form->getData();

            if($measure instanceof Measure)
            {
                if(null === $measure->getId())
                {
                    $existingMeasure = $repository->findOneBy(array('date' => $measure->getDate(),'isGoal' => 1, 'typeMeasure' => $measure->getTypeMeasure(), 'user' => $measure->getUser()));
                }
               
                
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
            
            
            $em->flush();
            
            $flashBag->add('success', 'Vos mesures ont bien été enregistrées');
                        
            return $this->redirect($this->generateUrl('_homepage'));
        }
        elseif($form->isSubmitted()) {
            $flashBag->add('error', 'Il y a une ou plusieurs erreurs dans votre formulaire.');
        }
        
        
        return $this->render('SportacusCoreBundle:Goal:index.html.twig', 
    		array(
				'form' => $form->createView(),
            )
        );
    }
    
    public function deleteAction(Request $request, $id)
    {
        $user = $this->getUser();
        
        if($user === null)
        {
            $user = $this->getDoctrine()->getManager()
            ->getRepository('SportacusCoreBundle:User')
            ->find(2)
            ;
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SportacusCoreBundle:Measure');
        $session = $request->getSession();
        $flashBag = $session->getFlashBag();
        
        $goal = $repository->find($id);
        
        if($goal === null)
        {
            throw $this->createNotFoundException("L'objectif que vous souhaitez supprimer n'existe pas.");
        }
        
        
        if($goal->getIsGoal() === false)
        {
            throw $this->createNotFoundException("L'objectif que vous souhaitez supprimer n'est pas un objectif. Vous ne pouvez supprimer que des objectifs"); 
        }
        
        
        if($goal->getUser() !== $user)
        {
            throw $this->createNotFoundException("Vous ne pouvez supprimer que vos objectifs");
        }
        
        
        $em->remove($goal);
        $em->flush();
        
        $flashBag->add('success', 'Votre objectif a bien été supprimé');
        
        return $this->redirect($this->generateUrl('_homepage'));
    }
}
