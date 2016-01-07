<?php
namespace Sportacus\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sportacus\CoreBundle\Entity\TypeMeasure;
use Sportacus\CoreBundle\Entity\User;

class GoalType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $paramsDate = [
	        'input'       => 'datetime',
	        'attr'        => array('class' => 'datepicker'),
	        'format'      => 'dd/MM/yyyy',
            'label'       => false,
	        'widget'      => 'single_text',
            'data'        => new \DateTime(),
            'required'    => true,
        ];
	    
	    $paramsTypeMeasure = [
		      'class'    => 'SportacusCoreBundle:TypeMeasure',
		      'property' => 'name',
	          'attr'     => array('class' => 'typeMeasure'),
		      'label'    => false
	    ];
	    
	    $paramsUser = [];
	    $paramsUser = [
	        'class'    => 'SportacusCoreBundle:User',
	        'property' => 'username',
	        'attr'     => array('class' => 'selectUser'),
	        'label'    => false,
	        'required' => true,
	    ];
	    
	    if(null !== $options['typeMeasure'] && $options['typeMeasure'] instanceof TypeMeasure){
	        $paramsTypeMeasure['data'] = $options['typeMeasure'];
	    }
	    
	    if(null !== $options['user'] && $options['user'] instanceof User){
	        $paramsUser['data'] = $options['user'];
	    }

	    $builder->add('user', 'entity', $paramsUser);
	    
		$builder
		  ->add('date', 'date', $paramsDate)
		  ->add('typeMeasure', 'entity', $paramsTypeMeasure)
		  ->add('value', 'number', ['label' => false])
		;
	}
	
	public function getName()
	{
	    return 'measure';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class'  => 'Sportacus\CoreBundle\Entity\Measure',
	        'typeMeasure' => null,
	        'user'        => null,
	    ));
	}
}