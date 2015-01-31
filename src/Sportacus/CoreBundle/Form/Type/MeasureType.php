<?php
namespace Sportacus\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sportacus\CoreBundle\Entity\TypeMeasure;

class MeasureType extends AbstractType
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
	    
	    if(null !== $options['typeMeasure'] && $options['typeMeasure'] instanceof TypeMeasure){
	        $paramsTypeMeasure['data'] = $options['typeMeasure'];
	    }
	    
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
	        'data_class' => 'Sportacus\CoreBundle\Entity\Measure',
	        'typeMeasure' => null
	    ));
	}
}