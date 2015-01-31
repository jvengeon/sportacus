<?php
namespace Sportacus\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $paramsDate = [
	        'input'       => 'datetime',
	        'format'      => 'dd/MM/yyyy',
            'label'       => 'Date',
	        'widget'      => 'single_text',
            'data'        => new \DateTime(),
            'required'    => true,
        ];
	    
		$builder
		  ->add('date', 'date', $paramsDate)
		;
	}
	
	public function getName()
	{
	    return 'date';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'inherit_data' => true,
	    ));
	}
}