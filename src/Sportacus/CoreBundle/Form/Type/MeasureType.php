<?php
namespace Sportacus\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeasureType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $paramsDate = [
	        'input'       => 'datetime',
	        'format'      => 'dd-MM-yyyy',
            'label'       => 'Date',
	        'widget'      => 'single_text',
            'empty_value' => '',
            'required'    => true,
        ];
	    
	    $paramsTypeMeasure = [
		      'class' => 'SportacusCoreBundle:TypeMeasure',
		      'property' => 'name',
		      'label' => 'Type de mesure'
		  ];
	    
		$builder
		  ->add('date', 'date', $paramsDate)
		  ->add('typeMeasure', 'entity', $paramsTypeMeasure)
		  ->add('value', 'number')
		  ->add('submit', 'submit', array(
		      'label' => 'Valider')
		  );
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
	    ));
	}
}