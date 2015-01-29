<?php

namespace Sportacus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        
        

        
        $this->aggregateMeasuresByDate($measures);

        return $this->render('SportacusCoreBundle:Home:index.html.twig', array('measures' => $measures));
    }
    
    private function aggregateMeasuresByDate(array $measures)
    {
        /* On doit recreer un tableau
         * [
         *  '2014-01-01' => [Measure1, Measure2],
         *  '2014-01-02' => [Measure3],
         *  '2014-01-03' => [Measure4, Measure5],
         * ]
         * */
        
        foreach($measures as $measure)
        {
            
        }
        
        
    }
}
