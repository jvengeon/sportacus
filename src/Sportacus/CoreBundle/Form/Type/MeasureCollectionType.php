<?php
namespace Sportacus\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MeasureCollectionType extends AbstractType
{
    private $doctrine;
    
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $paramsDate = [
	        'input'       => 'datetime',
	        'attr'        => array('id' => 'mainDate',  'class' => 'mainDatepicker'),
	        'format'      => 'dd/MM/yyyy',
            'label'       => 'Date',
	        'widget'      => 'single_text',
            'data'        => new \DateTime(),
            'required'    => true,
	        'mapped'      => false
        ];

	    $builder->add('date', 'date', $paramsDate);
	    
	    $typeMeasures = $this->getTypeMeasures();
	    
	    foreach($typeMeasures as $key => $typeMeasure) {
	        $builder->add($key, new MeasureType, [
               'typeMeasure' => $typeMeasure,
	           'label'       => ucfirst($typeMeasure->getName()),
	        ]);
	    }
	    
	    $builder->add('submit', 'submit', ['label' => 'Valider']);
	}
	
	private function getTypeMeasures()
	{
	    return $this->doctrine
	        ->getManager()
        	->getRepository('SportacusCoreBundle:TypeMeasure')
        	->findAll()
        ;
	}
	
	public function getName()
	{
	    return 'measure';
	}
	
}