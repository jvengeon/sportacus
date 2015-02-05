<?php
namespace Sportacus\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Sportacus\CoreBundle\Entity\User;

class MeasureCollectionType extends AbstractType
{
    private $doctrine;
    
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $user = null;
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
	    
	    if(null !== $options['user'] && $options['user'] instanceof User){
	        $user = $options['user'];
	    }
	    
	    
	    foreach($typeMeasures as $key => $typeMeasure) {
	        $builder->add($key, new MeasureType, [
               'typeMeasure' => $typeMeasure,
	            'user'       => $user,
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
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'user' => null
	    ));
	}
	
	public function getName()
	{
	    return 'measure';
	}
	
}